<?php

namespace Devsbuddy\AdminrEngine;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Devsbuddy\AdminrEngine\Skeleton\SkeletonClass
 */
class AdminrFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'adminr-engine';
    }
}
