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
Route::get('/dashboard', 'DashboardController@index');
Route::post('/caren/auth', 'CarenAuthController@sendCarenAuthRequest');


Route::group(['middleware' => ['web']], function () {
    Route::get('/caren/auth/callback', 'CarenAuthController@getCarenAuthCallback');
    Route::post('/caren/auth/destroy', 'CarenAuthController@destroySession');

    Route::get('/setup/client', 'CarenSetupController@setupAsClient');
    Route::get('/setup/master', 'CarenSetupController@setupAsMaster');

    Route::get('/caren/call/setupcall', 'CarenCallController@sendCallConnectRequest');
    Route::post('/caren/call/recieving', 'CarenCallController@getCallConnectStatus');
});

