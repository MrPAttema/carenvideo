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
Route::post('/pusher/auth/private', 'CarenAuthController@pusherPrivateAuth');
Route::post('/pusher/auth/presence', 'CarenAuthController@pusherPresenceAuth');


Route::group(['middleware' => ['web']], function () {
    Route::get('/caren/auth/callback', 'CarenAuthController@getCarenAuthCallback');
    Route::post('/caren/auth/destroy', 'CarenAuthController@destroySession');

    Route::get('/setup/client', 'CarenSetupController@setupAsClient');
    Route::get('/setup/master', 'CarenSetupController@setupAsMaster');

    Route::get('/caren/call/setup', 'CarenCallController@sendCallConnectRequest');
    Route::post('/caren/call/recieving', 'CarenCallController@getCallConnectStatus');
    Route::post('/caren/call/checkuid', 'CarenCallController@getCallConnectStatus');

    Route::get('/user/current', 'CarenUserController@getCarenUserData');
    Route::post('/user/update', 'CarenUserController@updateCarenUserData');
});

