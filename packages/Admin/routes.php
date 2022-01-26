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
    $router->post('users', 'UserController@index');
    $router->get('users/{user}/show', 'UserController@show');
    $router->get('users/{user}/destroy', 'UserController@destroy');
    $router->post('users/{user}/ban', 'UserController@ban');
    $router->post('users/{user}/update', 'UserController@update');
    $router->post('users/{user}/change-roles', 'UserController@changeRoles');

    $router->get('roles', 'RoleController@index');
});
