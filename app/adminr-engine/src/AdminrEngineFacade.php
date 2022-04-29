<?php

namespace Devsbuddy\AdminrEngine;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Devsbuddy\AdminrEngine\Skeleton\SkeletonClass
 */
class AdminrEngineFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'adminr-engine';
    }
}
