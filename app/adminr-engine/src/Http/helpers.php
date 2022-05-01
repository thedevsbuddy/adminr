<?php

use Illuminate\Support\Facades\Route;


if(!function_exists('coreUiIcon')){
    function coreUiIcon($id): string
    {
        return asset('vendor/adminr-engine/coreui/free.svg#'.$id);
    }
}

if (!function_exists('activeRoutes')) {
    function activeRoutes($routes): bool
    {
        return in_array(Route::currentRouteName(), $routes);
    }
}

if (!function_exists('activeRoute')) {
    function activeRoute($route): bool
    {
        return Route::currentRouteName() == $route;
    }
}


if (!function_exists('returnIfRoute')) {
    function returnIfRoute($route, $return, $fallback = null): mixed
    {
        if(Route::currentRouteName() == $route){
            return $return;
        } else {
            return $fallback;
        }
    }
}


/**
 * Return provided value if current route
 * matches with the provided route name
 *
 * @param String $route
 * @param mixed $return
 * @param mixed $fallback
 * @return boolean
 */
if (!function_exists('returnIfRoutes')) {
    function returnIfRoutes($routes, $return, $fallback = null)
    {
        if(in_array(Route::currentRouteName(), $routes)){
            return $return;
        } else {
            return $fallback;
        }
    }
}

if (!function_exists('getVersion')) {
    function getVersion(string $prefix = null)
    {
        $file = \Illuminate\Support\Facades\File::get(base_path() . '/composer.json');
        return $prefix . '' . json_decode($file)->version;
    }
}
