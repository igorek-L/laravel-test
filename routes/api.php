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

Route::group(['middleware' => 'auth.api'], function () {
    Route::get('logout', 'Auth\LoginController@logout');
    Route::post('edit', 'Admin\AdminController@edit')->middleware('admin.role');
    Route::group(['middleware' => 'user.role'], function () {
        Route::post('create-post', 'Post\PostController@createPost');
        Route::post('upload-image', 'Post\PostController@uploadImage');
        Route::get('posts', 'Post\PostController@getPosts');
        Route::get('posts/mostcommented', 'Post\PostController@getMostCommentedPostsByYear');
        Route::get('posts/{id}', 'Post\PostController@getPost');
        Route::get('/user/{userId}/posts', 'Post\UserPostController@getPosts');
        Route::get('/user/{userId}/mostcommented', 'Post\UserPostController@getMostCommentedPostsByYear');
        Route::post('add-comment', 'Comment\CommentController@create');
    });
});






