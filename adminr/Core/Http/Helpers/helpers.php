<?php

use Adminr\Core\Adminr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('resourcesPath')) {
    function resourcesPath(?string $path = null): ?string
    {
        return base_path('adminr/Resources/' . $path);
    }
}


if (!function_exists('stubsPath')) {
    function stubsPath($stub): ?string
    {
        return base_path('adminr/Core/Stubs/' . $stub . '.stub');
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

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($route): bool
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

if (!function_exists('adminrIcon')) {
    function adminrIcon(?string $id = null): string
    {
        return asset('adminr/icons/ui-icons.svg#' . $id);
    }
}

if (!function_exists('sanitizePath')) {
    function sanitizePath($path): string
    {
        return Str::replace('\\', '/', $path);
    }
}
