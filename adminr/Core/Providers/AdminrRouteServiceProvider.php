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
        $resourceArray = ModuleHelper::getResources();
        info($resourceArray);
        $this->routes(function () use ($resourceArray) {
            foreach ($resourceArray as $resource) {
                if (File::exists(resourcesPath($resource->name . '/Routes/web.php'))) {
                    Route::middleware('web')
                        ->namespace("Adminr\\Resources\\" . $resource->name . "\\Http\\Controllers")
                        ->group(resourcesPath($resource->name . '/Routes/web.php'));
                }

                if (File::exists(resourcesPath($resource->name . '/Routes/api.php'))) {
                    Route::middleware('api')
                        ->prefix('api')
                        ->namespace("Adminr\\Resources\\" . $resource->name . "\\Http\\Controllers\\Api")
                        ->group(resourcesPath($resource->name . '/Routes/api.php'));
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
