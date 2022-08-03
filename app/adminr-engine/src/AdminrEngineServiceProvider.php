<?php

namespace Devsbuddy\AdminrEngine;

use Devsbuddy\AdminrEngine\ViewComposers\MenuComposer;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminrEngineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminr-engine');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminr-engine');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/Http/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('adminr-engine.php'),
            ], 'config');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/adminr-engine'),
            ], 'laravel-assets');


            // Registering package commands.
            // $this->commands([]);
        }

        // Load helpers file
        if (file_exists(__DIR__ . '/Http/helpers.php')) {
            require_once __DIR__ . '/Http/helpers.php';
        }

        /**
         * Load menus and compose to all views
         */
        View::composer('adminr.includes.sidebar', MenuComposer::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'adminr-engine');

        // Register the main class to use with the facade
        $this->app->singleton('adminr-engine', function () {
            return new Adminr;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Adminr', Adminr::class);
    }
}
