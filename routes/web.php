<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect(\route('filament.auth.login'));
});
// Public Routes
Route::get('/', [HomeController::class, 'index'])
     ->name('home');
Route::group(['middleware' => 'filamentAuth'], function () {
    Route::post('createOrder/{product}', CheckoutController::class)
         ->name('checkout');
});
