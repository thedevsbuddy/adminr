<?php

namespace Adminr\System\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class AdminrRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $moduleArray = json_decode(File::get(__DIR__ . "/../modules.json"));

        $this->routes(function () use ($moduleArray) {
            foreach ($moduleArray as $module) {
                if (File::exists(module_path($module->name . '/Routes/web.php'))) {
                    Route::middleware('web')
                        ->namespace("Adminr\\Resource\\" . $module->name . "\\Http\\Controllers")
                        ->group(module_path($module->name . '/Routes/web.php'));
                }

                if (File::exists(module_path($module->name . '/Routes/api.php'))) {
                    Route::middleware('api')
                        ->prefix('api')
                        ->namespace("Adminr\\Resource\\" . $module->name . "\\Http\\Controllers\\Api")
                        ->group(module_path($module->name . '/Routes/api.php'));
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
