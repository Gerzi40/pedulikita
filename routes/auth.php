<?php

use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

// Start Guest
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('guest.register');
    Route::post('/register', 'store')->name('guest.register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'create')->name('guest.login');
    Route::post('/login', 'store')->name('guest.login');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'create')->name('password.request');
    Route::post('/forgot-password', 'store')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'create')->name('password.reset');
    Route::post('/reset-password', 'store')->name('password.store');
});
// End Guest

// Start Auth
Route::post('/user/logout', [LoginController::class, 'destroy'])->name('user.logout');
// End Auth
