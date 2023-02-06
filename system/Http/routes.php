<?php

use Adminr\System\Http\Controllers\BuilderController;
use Adminr\System\Http\Controllers\ResourceController;
use Adminr\System\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'adminr', 'middleware' => ['web'], 'as' => 'adminr.'], function () {
    Route::redirect('/', 'adminr/dashboard', 301);
    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::get('/builder', [BuilderController::class, 'index'])->name('builder');
        Route::post('/generate', [BuilderController::class, 'build']);

        // Manage all resources
        Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
        Route::get('/resources/{id}/configure', [ResourceController::class, 'configure'])->name('resources.configure');
        Route::delete('/resources/delete/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');
        Route::get('/get-resource/{id}', [ResourceController::class, 'getResource']);
        Route::post('/update-api-middleware/{id}', [ResourceController::class, 'updateApiMiddlewares']);
        Route::get('/get-roles', [RolePermissionController::class, 'getRoles']);
        Route::get('/get-permissions/{id}', [RolePermissionController::class, 'getPermissions']);
        Route::post('/sync-role-permissions', [RolePermissionController::class, 'assignPermissionsToRoles']);

        Route::get('/get-model-list', [ResourceController::class, 'getModelList']);
        Route::post('/get-model-columns', [ResourceController::class, 'getModelColumns']);
    });
});
