<?php

use App\Http\Controllers\Api\Auth\AuthenticateController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\ProductApiController;
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
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('products', [ProductApiController::class, 'index'])->name('products.index');
    Route::get('products/{id}', [ProductApiController::class, 'show'])->name('products.show');

    Route::get('cart',  [CartApiController::class, 'index'])->name('cart.index');
    Route::post('cart',  [CartApiController::class, 'store'])->name('cart.store');
    Route::put('cart',  [CartApiController::class, 'update'])->name('cart.update');
    Route::delete('cart/{id}', [CartApiController::class, 'destroy'])->name('cart.destroy');
    Route::post('orders', [CheckoutApiController::class, 'store'])->name('orders.store')->middleware('auth:sanctum');
    Route::get('orders', [CheckoutApiController::class, 'index'])->name('orders.index')->middleware('auth:sanctum');
    Route::get('orders/{id}', [CheckoutApiController::class, 'show'])->name('orders.show')->middleware('auth:sanctum');

    
});

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ //...
});