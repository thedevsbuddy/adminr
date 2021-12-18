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

$adminrRoutes = json_decode(File::get(__DIR__ . '/api/routes.json'));
foreach ($adminrRoutes as $key => $adminrRoute){
    $routes = json_decode(File::get(__DIR__ . '/api/'.$key.'/'.$adminrRoute));
    foreach ($routes as $index => $route){
        if(isset($route)){
            if($route->method == 'get') {
                Route::get($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware);
            } elseif($route->method == 'post') {
                Route::post($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware);
            } elseif($route->method == 'put') {
                Route::put($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware);
            } elseif($route->method == 'delete') {
                Route::delete($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware);
            } elseif($route->method == 'patch') {
                Route::patch($route->route, [$route->controller, $route->action])
                    ->middleware($route->middleware);
            }
        }
    }
}