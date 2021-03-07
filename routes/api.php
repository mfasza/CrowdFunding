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
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog'
], function(){
    Route::get('random/{count}', 'BlogController@random');
    Route::post('store', 'BlogController@store');
});