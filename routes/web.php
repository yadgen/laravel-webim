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

Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::post('/act_login', ['as' => 'act_login', 'uses' => 'LoginController@act_login']);
Route::get('/register', ['as' => 'register', 'uses' => 'RegisterController@index']);
Route::post('/act_register', ['as' => 'act_register', 'uses' => 'RegisterController@act_register']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LogoutController@index']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
});
