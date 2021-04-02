<?php

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

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->middleware('api')->prefix('auth')->group(function(){
    Route::post('register', 'RegisterController');
    Route::post('verification', 'VerificationController');
    Route::post('regenerate-otp', 'RegenerateOtpController');
    Route::post('update-password', 'UpdatePasswordController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController')->middleware('auth:api');
    Route::post('check-token', 'CheckTokenController')->middleware('auth:api');

    Route::get('/social/{provider}', 'SocialiteController@redirectToProvider');
    Route::get('/social/{provider}/callback', 'SocialiteController@handleProviderCallback');
});

Route::namespace('Profile')->middleware(['api', 'emailVerified', 'auth:api'])->prefix('profile')->group(function(){
    Route::get('get-profile', 'ProfileController@show');
    Route::post('update-profile', 'ProfileController@update');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'campaign'
], function(){
    Route::get('random/{count}', 'CampaignController@random');
    Route::post('store', 'CampaignController@store');
    Route::get('/', 'CampaignController@index');
    Route::get('/{id}', 'CampaignController@detail');
    Route::get('/search/{keyword}', 'CampaignController@search');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog'
], function(){
    Route::get('random/{count}', 'BlogController@random');
    Route::post('store', 'BlogController@store');
});

Route::group([
    'middleware' => ['api', 'emailVerified', 'auth:api',],
    'prefix' => 'chat'
], function ()
{
    Route::get('/get-all-users', 'ChatController@getAllUsers');
    Route::get('/get-discuss', 'ChatController@discussChats');
    Route::post('/store-discuss', 'ChatController@storeDiscuss');
    Route::get('/get-admin/{user_id}', 'ChatController@adminChats');
    Route::post('/store-admin/{user_id}', 'ChatController@storeAdmin');
});