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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('users/authendicate',  ['uses' => 'AuthController@authendicate']);

});

$router->group(['middleware' => ['auth'], 'prefix' => 'api'], function () use ($router) {

    $router->post('users/create', ['uses' => 'UserController@store']);

    $router->post('groups/create', ['uses' => 'GroupController@store']);

    $router->post('usergroups/create', ['uses' => 'UserGroupsController@store']);

    $router->post('expense/create', ['uses' => 'ExpenseController@store']);

    $router->get('users/{id}', ['uses' => 'UserController@show']);

    $router->get('groups/{id}', ['uses' => 'GroupController@show']);

    $router->get('expense/{group_id}', ['uses' => 'ExpenseController@show']);

    $router->get('expense/users/{user_id}', ['uses' => 'ExpenseController@showGroupExpense']);

    $router->get('expense/groups/{group_id}', ['uses' => 'ExpenseController@showGroupBalance']);

});