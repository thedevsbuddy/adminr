<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MailTestController;
use App\Http\Controllers\Admin\RoleAndPermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Mail;
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => '/manage'], function () {
        // Manage Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Roles and Permissions routes
        Route::get('/roles-and-permissions', [RoleAndPermissionController::class, 'index'])->name('roles-and-permissions.index');
        Route::post('/assign-permission', [RoleAndPermissionController::class, 'assignPermission'])->name('roles-and-permissions.assign');
        Route::post('/revoke-permission', [RoleAndPermissionController::class, 'revokePermission'])->name('roles-and-permissions.revoke');
        Route::post('/store-role', [RoleAndPermissionController::class, 'storeRole'])->name('roles-and-permissions.storeRole');
        Route::post('/store-permission', [RoleAndPermissionController::class, 'storePermission'])->name('roles-and-permissions.storePermission');

        // Mail Templates Routes
        Route::resource('/templates', TemplateController::class);

        // Settings routes
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });

    // Send Test Mail
    Route::post('/test-mail', [MailTestController::class, 'send'])->name('test-mail');

});
