<?php

use Illuminate\Routing\Router;

$router = app('router');

$adminAttributes = [
    'namespace'  => 'Packages\Admin\Controllers',
    'prefix'     => 'api/admin',
    'as'         => 'admin.',
    'middleware' => 'api'
];

$router->group($adminAttributes, function (Router $router) {
    $router->get('users', 'UserController@index');
});
