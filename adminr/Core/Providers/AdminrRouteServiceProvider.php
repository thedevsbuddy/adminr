<?php

namespace Adminr\Core\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Adminr\Core\Http\Helpers\ModuleHelper;

class AdminrRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $moduleArray = ModuleHelper::getModules();

        $this->routes(function () use ($moduleArray) {
            foreach ($moduleArray as $module) {
                if (File::exists(resourcesPath($module->name . '/Routes/web.php'))) {
                    Route::middleware('web')
                        ->namespace("Adminr\\Resource\\" . $module->name . "\\Http\\Controllers")
                        ->group(resourcesPath($module->name . '/Routes/web.php'));
                }

                if (File::exists(resourcesPath($module->name . '/Routes/api.php'))) {
                    Route::middleware('api')
                        ->prefix('api')
                        ->namespace("Adminr\\Resource\\" . $module->name . "\\Http\\Controllers\\Api")
                        ->group(resourcesPath($module->name . '/Routes/api.php'));
                }
            }
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
