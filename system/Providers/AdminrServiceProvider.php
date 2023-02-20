<?php

namespace Adminr\System\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Adminr\System\ViewComposers\MenuComposer;
use Adminr\System\Adminr;
use Adminr\System\Facades\AdminrFacade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Adminr\System\Http\Helpers\ModuleHelper;

class AdminrServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /// Register all the module routes
        $this->app->register(AdminrRouteServiceProvider::class);

        /// Load all the relationships when needed
        $this->app->register(AdminrRelationshipServiceProvider::class);

        // Register the main class to use with the facade
        $this->app->singleton('adminr', fn() => new Adminr);

        $loader = AliasLoader::getInstance();
        $loader->alias('Adminr', AdminrFacade::class);
        $loader->alias('ModuleHelper', ModuleHelper::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminr');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        /// Load menus and compose to all views
        View::composer('adminr::adminr-resource-menus', MenuComposer::class);

        // Register Blade directive
        Blade::directive('adminrResources', fn() => "<?php echo \$__env->make('adminr::adminr-resource-menus')->render(); ?>");


        /// Loading all the views from modules
        $moduleArray = ModuleHelper::getModules();
        foreach ($moduleArray as $module) {
            $viewPath = module_path($module->name . '/Views');

            if (File::isDirectory($viewPath)) {
                $this->loadViewsFrom($viewPath, Str::snake($module->name));
            }
        }
    }
}
