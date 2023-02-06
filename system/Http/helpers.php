<?php

use Adminr\System\Adminr;

if (!function_exists('module_path')) {
    function module_path(string $path): ?string
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
