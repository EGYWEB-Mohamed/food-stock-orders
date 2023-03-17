<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'filamentAuth'],function (){
    Route::post('createOrder/{product}',[HomeController::class,'checkout'])->name('checkout');
});
