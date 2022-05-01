<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest', 'as' => 'auth.'], function (){
    // Login related routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    // Register related routes
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Verification related routes
    Route::get('/verify-email', [VerificationController::class, 'verifyEmail'])->name('verify-email');
});

Route::group(['middleware' => 'auth', 'as' => 'auth.'], function (){
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
