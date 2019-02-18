<?php
// Let's Boot our App

$startTime = microtime(true);
$startMemory = round(memory_get_usage(false) / 1024 / 1024, 2);


define('ROOT_DIR', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define("NS", '\\');

require ROOT_DIR . DS . 'vendor' . DS . 'autoload.php';

define('APP_DIR', ROOT_DIR . DS . 'src');
define('PUBLIC_DIR', 'public');
define('CONFIG_DIR', ROOT_DIR . DS . 'config');
define('VAR_DIR', ROOT_DIR . DS . 'var');

/*
 * Temp
 */

define('DATETIME_FORMAT', 'Y-m-d H:i:s');
define("DATETIME", date(DATETIME_FORMAT));
define("DATE", date('Y-m-d'));

if (!empty($_SERVER['HTTP_HOST'])) {
    define("CURRENT_URL", (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] . '://' : ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://')) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
} else {
    define('CURRENT_URL', '');
}

if (strpos(CURRENT_URL, '?') !== false) {
    define('CURRENT_MAINURL', strstr(CURRENT_URL, '?', true));
} else {
    define('CURRENT_MAINURL', CURRENT_URL);
}

require CONFIG_DIR . DS . 'config.php';

use Falgun\DInjector\Singleton;
use Falgun\Reporter\DevReporter;

if (isDebug()) {
    /**
     * Lets prepare everything for developer reporting
     * Report will be generated on script destruction
     */
    $reporter = new DevReporter($startTime, $startMemory);
    Singleton::set($reporter);
}

/**
 *  Let's not hate errors
 *  Love them and make them love you
 *  We will handle error as they deserve
 */
use Falgun\FancyError\ErrorHandler;

new ErrorHandler();

/**
 *  Load and initiate routes
 *  Will return Router instance
 */
$router = require APP_DIR . DS . 'routes.php';

/**
 *  We will now start to load our task manager
 *  He is responsible for all MVC related calls
 */
use Falgun\Manager\Manager;

$taskManager = new Manager($router);
$taskManager->manage();
