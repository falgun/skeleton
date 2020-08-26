<?php

namespace App;

use Falgun\Routing\Router;
use App\Controllers\WelcomeController;

// $config is available here
$router = new Router($config->get('BASE_URL'));

$router->any('/')->action(WelcomeController::class, 'index');

// must return $router
return $router;
