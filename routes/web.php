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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/{any?}', 'app')->where('any', '.*');

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::middleware(['auth', 'emailVerified'])->group(function ()
// {
//     Route::get('/route-1', 'HomeController@email');
//     Route::get('/route-2', 'HomeController@admin')->middleware('isAdmin');
// });
