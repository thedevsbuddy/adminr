<?php

Route::controller(BlogController::class)->as('blog.')->prefix('blog')->group(function () {

    /// Index Route
    Route::get('/', 'index')->name('index');

});

