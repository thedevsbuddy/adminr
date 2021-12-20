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
Route::group(['prefix' => config('app.route_prefix'), 'middleware' => ['web', 'auth', 'admin'], 'as' => config('app.route_prefix').'.'], function() {
    Route::redirect('/', config('app.route_prefix').'/dashboard', 301);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => '/manage'], function () {
        // Manage Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Settings routes
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });

    // Send Test Mail
    Route::post('/test-mail', function (\Illuminate\Http\Request $request){
        \Illuminate\Support\Facades\Mail::to($request->get('email'))->send(new \App\Mail\TestMail());
        return back()->with('success', 'Mail send successfully!');
    })->name('test-mail');

});