<?php

namespace Devsbuddy\AdminrEngine;

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

}
