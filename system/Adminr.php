<?php

namespace Adminr\System;

use Adminr\System\Traits\WorksWithStubs;
use Illuminate\Support\Facades\File;

class Adminr
{
    use WorksWithStubs;

    public static function inDev(): bool
    {
        return config('adminr.app_mode') == 'dev';
    }

    public static function inPublic(): bool
    {
        return config('adminr.app_mode') == 'public';
    }

    public static function version(?string $prefix = null): string
    {
        $file = File::get(base_path('/composer.json'));
        return $prefix . '' . json_decode($file)->version;
    }
}
