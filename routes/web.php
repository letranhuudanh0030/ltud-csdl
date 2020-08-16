<?php

use App\Mail\RequestUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/change-status/{event_id}/{user_id}/{status}', 'API\EventsController@changeStatus');

Route::get('/mailable', function(){
    $event = App\Event::find(2);
    return new RequestUser($event, '123');
});
