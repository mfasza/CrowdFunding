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

Route::namespace('Auth')->middleware('api')->group(function(){
    Route::post('auth/register', 'RegisterController');
    Route::post('auth/verification', 'VerificationController');
    Route::post('auth/regenerate-otp', 'RegenerateOtpController');
    Route::post('auth/update-password', 'UpdatePasswordController');
    Route::post('auth/login', 'LoginController');
});

Route::namespace('Profile')->middleware(['api', 'emailVerified', 'auth:api'])->group(function(){
    Route::get('profile/get-profile', 'ProfileController@show');
    Route::post('profile/update-profile', 'ProfileController@update');
});
