<?php

use Core\Router\Router;
use Core\View\View;

use App\controller\HomeController;

Router::get('', [HomeController::class, 'index']);

Router::post('/upload-ajax', [HomeController::class, 'uploadAjax']);

// Router::get('/name/{name}', function ($name) {
//     return View::render('home.tpl', ['name' => $name]);
// });