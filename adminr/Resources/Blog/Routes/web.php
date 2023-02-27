<?php

use Illuminate\Support\Facades\Route;
use Adminr\Resources\Article\Http\Controllers\ArticleController;

Route::group(['as' => 'adminr.articles.', 'prefix' => config('adminr.path') . '/manage/articles'], function () {
    Route::get('/', [ArticleController::class, 'index'])->middleware("permission:articles_list")->name("index");
    Route::get('/create', [ArticleController::class, 'create'])->middleware("permission:articles_create")->name("create");
    Route::post('/store', [ArticleController::class, 'store'])->middleware("permission:articles_store")->name("store");
    Route::get('/{article}', [ArticleController::class, 'show'])->middleware("permission:articles_single")->name("show");
    Route::get('/{article}/edit', [ArticleController::class, 'edit'])->middleware("permission:articles_edit")->name("edit");
    Route::put('/{article}', [ArticleController::class, 'update'])->middleware("permission:articles_update")->name("update");
    Route::delete('/{article}', [ArticleController::class, 'destroy'])->middleware("permission:articles_destroy")->name("destroy");
    Route::post('/{article}/restore', [ArticleController::class, 'restore'])->middleware("permission:articles_restore")->name("restore");
    Route::delete('/{article}/force-destroy', [ArticleController::class, 'forceDestroy'])->middleware("permission:articles_force_destroy")->name("force-destroy");
});
