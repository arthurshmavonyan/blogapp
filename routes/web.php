<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::prefix('api')->group(function () {
    Route::get('me', 'Api\UsersController@me');
    Route::put('users/{user}', 'Api\UsersController@update');

//  Resources

    Route::resource('posts', 'Api\PostsController');

//  Others
    Route::post('deleteavatar/{user}', 'Api\UsersController@deleteAvatar');
});
