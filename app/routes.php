<?php

use Core\Router\Router;
use Core\View\View;

use App\controller\HomeController;
use App\controller\XmlController;

Router::get('', [HomeController::class, 'index']);

Router::post('/upload', [HomeController::class, 'upload']);

// Router::get('/name/{name}', function ($name) {
//     return View::render('home.tpl', ['name' => $name]);
// });