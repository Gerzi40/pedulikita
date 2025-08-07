<?php

use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store')->name('register');
    });
    
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store')->name('login');
    });
    
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'create')->name('password.request');
        Route::post('/forgot-password', 'store')->name('password.email');
    });
    
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'create')->name('password.reset');
        Route::post('/reset-password', 'store')->name('password.store');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
