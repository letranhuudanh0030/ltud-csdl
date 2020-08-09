<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users/{id}/tasks', 'API\UsersController@showTask');
Route::apiResource('users', 'API\UsersController', ['except' => ['create', 'edit']]);

Route::get('roles/{id}/users', 'API\RolesController@showUser');
Route::apiResource('roles', 'API\RolesController', ['except' => ['create', 'edit']]);

Route::get('customers/{id}/events', 'API\CustomersController@showEvent');
Route::apiResource('customers', 'API\CustomersController', ['except' => ['create', 'edit']]);

Route::get('events/{id}/tasks', 'API\EventsController@showTask');
Route::apiResource('events', 'API\EventsController', ['except' => ['create', 'edit']]);

Route::apiResource('tasks', 'API\TasksController', ['except' => ['create', 'edit']]);

Route::get('Event/{id}', 'API\EventUserController@destroyEvent@showUserOfEvent');
Route::apiResource('events', 'API\EventUserController', ['except' => ['create', 'edit','destroy']]);
