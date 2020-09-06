<?php

namespace App;

use Falgun\Routing\Router;
use App\Controllers\WelcomeController;

// $request is available here
/* @var $request \Falgun\Http\Request */

$router = new Router($request->uri()->getFullDocumentRootUrl());

$router->any('/')->action(WelcomeController::class, 'index');

// must return $router
return $router;
