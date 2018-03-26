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

Route::get('/', 'WelcomeController@index');
Route::post('/caren/auth', 'CarenAuthController@sendCarenAuthRequest');

Route::get('/caren/auth/callback', 'CarenAuthController@getCarenAuthCallback');
Route::post('/caren/auth/destroy', 'CarenAuthController@destroySession');

Route::post('/caren/user/getdata', 'CarenUserController@getCarenUserData');
