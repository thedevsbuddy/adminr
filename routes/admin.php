<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * Add admin routes here if needed
 */



Route::group(['prefix' => config('app.route_prefix'), 'middleware' => ['web'], 'as' => config('app.route_prefix').'.'], function() {
    Route::group(['middleware' => ['auth', 'admin']], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');


        // Manage Users
        Route::get('/manage/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/manage/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/manage/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/manage/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/manage/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/manage/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Settings routes
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });
});