<?php


/**
 * Dynamic routes generation
 * We are generating dynamic routes for
 * each resource that you create
 * PLEASE DON'T CHANGE ANYTHING BELOW
 * THIS COMMENT OR ANYTHING IN THE
 * CODE BLOCK BELOW
 * it may break CMS functionality
 */

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ["web", "auth", "admin"], 'as' => 'admin.', 'prefix' => config('app.route_prefix').'/manage'], function (){
    $liquidRoutes = json_decode(File::get(__DIR__ . '/admin/routes.json'));
    foreach ($liquidRoutes as $key => $liquidRoute){
        $routes = json_decode(File::get(__DIR__ . '/admin/' . $key . '/' .$liquidRoute));
//        dump($routes);
        foreach ($routes as $index => $route){
            if($route->method == 'get') {
                Route::get($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware)
                    ->name($route->name);
            }
            if($route->method == 'post') {
                Route::post($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware)
                    ->name($route->name);
            }
            if($route->method == 'put') {
                Route::put($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware)
                    ->name($route->name);
            }
            if($route->method == 'delete') {
                Route::delete($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware)
                    ->name($route->name);
            }
            if($route->method == 'patch') {
                Route::patch($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware)
                    ->name($route->name);
            }
        }
    }
});