<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function (){
    // Login related routes
    Route::post('/login', [AuthController::class, 'login']);

    // Register related routes
    Route::post('/register', [AuthController::class, 'register']);

    // Verify Otp
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

});

Route::group(['middleware' => 'auth:sanctum'], function(){
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
