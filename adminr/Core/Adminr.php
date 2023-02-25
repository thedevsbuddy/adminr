<?php

namespace Adminr\Core;

use Adminr\Core\Traits\WorksWithStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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

    public static function log(mixed $data, string $type = 'info'): void
    {
        if (self::inDev()) Log::{$type}($data);
    }

    public static function version(?string $prefix = null): string
    {
        $file = File::get(base_path('/composer.json'));
        return $prefix . '' . json_decode($file)->version;
    }
}
