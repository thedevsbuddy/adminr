<?php

namespace Adminr\System\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Adminr\System\ViewComposers\MenuComposer;
use Adminr\System\Adminr;
use Adminr\System\Facades\AdminrFacade;

class AdminrServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /// Register all the module routes
        $this->app->register(AdminrRouteServiceProvider::class);

        // Register the main class to use with the facade
        $this->app->singleton('adminr', function () {
            return new Adminr;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Adminr', AdminrFacade::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'adminr');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        /// Load menus and compose to all views
        View::composer('adminr::adminr-resource-menus', MenuComposer::class);

        // Register Blade directive
        Blade::directive('adminrResources', function () {
            return "<?php echo \$__env->make('adminr::adminr-resource-menus')->render(); ?>";
        });
    }
}
