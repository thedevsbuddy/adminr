<?php

namespace Adminr\System\Facades;

use Illuminate\Support\Facades\Facade;

class AdminrFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'adminr';
    }
}
