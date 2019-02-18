<?php
namespace App;

use Falgun\Http\Routing\Router;

$router = new Router();

$router->any('/')->action(Controllers\HomeController::class, 'index');

return $router->dispatch();
