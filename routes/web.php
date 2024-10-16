<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/apple', 'App\Http\Controllers\Auth\SocialiteController@redirectToProvider');
Route::get('/login/apple/callback', 'App\Http\Controllers\Auth\SocialiteController@handleProviderCallback');

//Route::middleware(['swoole.reload'])->group(function () {
//    Route::get('/login/apple', 'App\Http\Controllers\Auth\SocialiteController@redirectToProvider');
//    Route::get('/login/apple/callback', 'App\Http\Controllers\Auth\SocialiteController@handleProviderCallback');
//});
