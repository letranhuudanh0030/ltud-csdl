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


Route::apiResource('users', 'API\UsersController', ['except' => ['create', 'edit']]);

Route::get('roles/{id}/users', 'API\RolesController@showUser');
Route::apiResource('roles', 'API\RolesController', ['except' => ['create', 'edit']]);

Route::get('customers/{id}/events', 'API\CustomersController@showEvent');
Route::apiResource('customers', 'API\CustomersController', ['except' => ['create', 'edit']]);

Route::apiResource('events', 'API\EventsController', ['except' => ['create', 'edit']]);
