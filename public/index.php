<?php
$startTime = \microtime(true);
$startMemory = \round(\memory_get_peak_usage(false) / 1024 / 1024, 2);

define('ROOT_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('NS', '\\');

require ROOT_DIR . DS . 'vendor' . DS . 'autoload.php';

use Falgun\Application\Config;
use Falgun\Application\Application;
use Falgun\Reporter\DevReporter;
use Falgun\Reporter\ProdReporter;
use Falgun\FancyError\ErrorHandler;
use Falgun\Routing\RouterInterface;
use Falgun\Fountain\SharedContainer;
use Falgun\Fountain\RuleBook;
use Falgun\Fountain\Fountain;
use Falgun\Http\Request;

$config = Config::fromFileDir(ROOT_DIR . '/config', ['ROOT_DIR' => ROOT_DIR]);

$appDir = ROOT_DIR . '/' . $config->getIfAvailable('APP_DIR', 'src');

/**
 *  Let's not hate errors
 *  Love them and make them love you
 *  We will handle error as they deserve
 */
if ($config->get('DEBUG')) {
    $mode = new Falgun\FancyError\Modes\DebugMode(ROOT_DIR);
} else {
    $mode = new Falgun\FancyError\Modes\ProductionMode($appDir, ROOT_DIR . '/var/errors');
}
$errorHandler = new ErrorHandler($mode);

$request = Request::createFromGlobals();

/**
 * Huge Memory Wasted here
 * FIX IT
 * Should we use another reporter for production?
 */
if ($config->get('DEBUG')) {
    /**
     * Lets prepare everything for developer reporting
     * Report will be generated on script destruction
     */
    $reporter = new DevReporter($request, $startTime, $startMemory);
} else {
    $reporter = new ProdReporter();
}

/**
 *  Load and initiate routes
 *  Will return Router instance
 */
$routeLoader = function () use($request, $appDir): RouterInterface {

    $router = require $appDir . '/routes.php';

    if (!$router instanceof RouterInterface) {
        throw new \Exception('routes.php must return an implementation of ' . RouterInterface::class);
    }

    return $router;
};

$router = $routeLoader();

$ruleBook = new RuleBook(require $appDir . '/fountain.php');
$container = new Fountain(new SharedContainer, $ruleBook);

$container->set(Config::class, $config);
$container->set(Request::class, $request);

if (isset($reporter)) {
    $container->set(DevReporter::class, $reporter);
}

$errorHandler->applicationBooted($container);

$middlewareGroups = [];
if (\file_exists($appDir . '/middlewares.php')) {
    $middlewareGroups = (require $appDir . '/middlewares.php');
}

$application = new Application($config, $container, $router, $middlewareGroups, $reporter);
$application->run($request);
