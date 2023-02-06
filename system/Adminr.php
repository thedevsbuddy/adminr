<?php

namespace Adminr\System;

use Illuminate\Support\Facades\File;

class Adminr
{
    public static function isInDev(): bool
    {
        return config('adminr.app_mode') == 'dev';
    }

    public static function isInPublic(): bool
    {
        return config('adminr.app_mode') == 'public';
    }

    public static function version(?string $prefix = null): string
    {
        $file = File::get(base_path('/composer.json'));
        return $prefix . '' . json_decode($file)->version;
    }
}
