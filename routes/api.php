<?php

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
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'Auth\RegisterController@register');
Route::get('admin', 'Admin\AdminController@index');

Route::group(['middleware' => 'AuthAPI'], function () {
    Route::put('logout', 'Auth\LoginController@logout');
    Route::post('edit', 'Admin\AdminController@edit')->middleware('adminRole');
    Route::post('create-post', 'Post\PostController@createPost')->middleware('userRole');
    Route::post('upload-image', 'Post\PostController@uploadImage')->middleware('userRole');
    Route::get('posts','Post\PostController@getPosts')->middleware('userRole');
    Route::get('posts/mostcommented','Post\PostController@getMostCommentedPostsByYear')->middleware('userRole');
    Route::get('posts/{id}','Post\PostController@getPost')->middleware('userRole');
    Route::get('/user/{userId}/posts','Post\UserPostController@getPosts')->middleware('userRole');
    Route::get('/user/{userId}/mostcommented','Post\UserPostController@getMostCommentedPostsByYear')->middleware('userRole');
    Route::post('add-comment', 'Comment\CommentController@create')->middleware('userRole');
});






