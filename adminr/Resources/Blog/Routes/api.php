<?php

use Illuminate\Support\Facades\Route;
use Adminr\Resources\Article\Http\Controllers\Api\ArticleController;

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', [ArticleController::class, 'index'])->middleware(getRouteMiddlewares(method: 'index', resourceName: 'articles'));
    Route::post('/store', [ArticleController::class, 'store'])->middleware(getRouteMiddlewares(method: 'store', resourceName: 'articles'));
    Route::get('/{article}', [ArticleController::class, 'show'])->middleware(getRouteMiddlewares(method: 'show', resourceName: 'articles'));
    Route::put('/{article}', [ArticleController::class, 'update'])->middleware(getRouteMiddlewares(method: 'update', resourceName: 'articles'));
    Route::delete('/{article}', [ArticleController::class, 'destroy'])->middleware(getRouteMiddlewares(method: 'destroy', resourceName: 'articles'));
    Route::post('/{article}/restore', [ArticleController::class, 'restore'])->middleware(getRouteMiddlewares(method: 'restore', resourceName: 'articles'));
    Route::delete('/{article}/force-destroy', [ArticleController::class, 'forceDestroy'])->middleware(getRouteMiddlewares(method: 'forceDestroy', resourceName: 'articles'));
});
