<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'WelcomeController@welcome');

$router->group(['prefix' => 'api/v1'], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');

    $router->group(['middleware' => 'auth:api'], function ($router) {
        $router->post('user-profile', 'AuthController@userProfile');
        $router->group(['prefix' => 'ip'], function ($router) {
            $router->post('create', 'IpManagementController@create');
            $router->patch('update/{id}', 'IpManagementController@update');
        });
    });
});
