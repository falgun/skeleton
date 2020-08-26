<?php

define('ROOT_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('NS', '\\');

require ROOT_DIR . DS . 'vendor' . DS . 'autoload.php';

use Falgun\Application\Config;
use Falgun\Application\Application;
use Falgun\Reporter\DevReporter;
use Falgun\FancyError\ErrorHandler;
use Falgun\Routing\RouterInterface;
use Falgun\Fountain\Fountain;
use Falgun\Http\Request;

$config = Config::fromFileDir(ROOT_DIR . '/config');

$appDir = ROOT_DIR . '/' . $config->getIfAvailable('APP_DIR', 'src');

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
    $reporter = new DevReporter();
}

/**
 *  Let's not hate errors
 *  Love them and make them love you
 *  We will handle error as they deserve
 */
$errorHandler = ErrorHandler::createFromConfig($config, ROOT_DIR);

/**
 *  Load and initiate routes
 *  Will return Router instance
 */
$routeLoader = function () use($config, $appDir): RouterInterface {

    $router = require $appDir . '/routes.php';

    if (!$router instanceof RouterInterface) {
        throw new \Exception('routes.php must return an implementation of ' . RouterInterface::class);
    }

    return $router;
};

$router = $routeLoader();

$container = new Fountain(new \Falgun\Fountain\SharedServices());

$request = Request::createFromGlobals();

$container->set(Config::class, $config);
$container->set(Request::class, $request);

if (isset($reporter)) {
    $container->set(DevReporter::class, $reporter);
}

$middlewareGroups = [];
if (\file_exists($appDir . '/middlewares.php')) {
    $middlewareGroups = (require $appDir . '/middlewares.php');
}

$application = new Application($config, $container, $router, $middlewareGroups, $reporter);
$application->run($request);
