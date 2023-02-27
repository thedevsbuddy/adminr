<?php

use Illuminate\Support\Facades\Route;
use Adminr\Resources\Article\Http\Middlewares\ArticleMiddleware;
use Adminr\Resources\Article\Http\Controllers\Api\ArticleController;

Route::group(['prefix' => 'articles'], function () {
    /// Register/Instantiate Middleware
    $middleware = new ArticleMiddleware();

    Route::get('/', [ArticleController::class, 'index'])->middleware($middleware->of('index'));
    Route::post('/store', [ArticleController::class, 'store'])->middleware($middleware->of('store'));
    Route::get('/{article}', [ArticleController::class, 'show'])->middleware($middleware->of('show'));
    Route::put('/{article}', [ArticleController::class, 'update'])->middleware($middleware->of('update'));
    Route::delete('/{article}', [ArticleController::class, 'destroy'])->middleware($middleware->of('destroy'));
    Route::post('/{article}/restore', [ArticleController::class, 'restore'])->middleware($middleware->of('restore'));
    Route::delete('/{article}/force-destroy', [ArticleController::class, 'forceDestroy'])->middleware($middleware->of('forceDestroy'));
});
