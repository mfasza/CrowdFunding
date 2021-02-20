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

Route::namespace('Auth')->group(function(){
    Route::post('register', 'RegisterController');
    Route::post('verification', 'VerificationController');
    Route::post('regenerate-otp', 'RegenerateOtpController');
    Route::post('update-password', 'UpdatePasswordController');
});
