<?php

use App\Http\Controllers\Api\Auth\AuthenticateController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::group([
    'middleware' => [ 'SetApiLocale']
], function(){
    Route::post('login', [AuthenticateController::class, 'login'])->name('login');
    Route::post('register', [AuthenticateController::class, 'register'])->name('register');
    
});

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ //...
});