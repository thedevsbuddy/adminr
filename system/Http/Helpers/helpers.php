<?php

use Adminr\System\Adminr;

if (!function_exists('module_path')) {
    function module_path(?string $path = null): ?string
    {
        return base_path('modules/' . $path);
    }
}


if (!function_exists('adminr')) {
    function adminr(?string $method = null, ...$args): Adminr|string
    {
        if ($method == null) return new Adminr;

        return (new Adminr)->{$method}(...$args);
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

if (!function_exists('inRoutes')) {
    function inRoutes($routes, $return, $fallback = null)
    {
        if (in_array(Route::currentRouteName(), $routes)) {
            return $return;
        } else {
            return $fallback;
        }
    }
}

if (!function_exists('coreUiIcon')) {
    function coreUiIcon($id): string
    {
        return asset('vendor/adminr-engine/coreui/free.svg#' . $id);
    }
}
