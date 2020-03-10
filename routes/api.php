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

Route::group(['middleware' => \App\Http\Middleware\AuthAPIMiddleware::class], function(){
    Route::post('edit','Admin\AdminController@edit')->middleware('adminRole');
    Route::put('logout','Auth\LoginController@logout');
});

Route::post('register', 'Auth\RegisterController@register');

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::get('admin','Admin\AdminController@index');




