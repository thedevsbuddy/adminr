<?php

return [
     /*===================================
     *  App Mode
     * -----------------------------------
     * Check for app mode if it is for
     * developers or the public
     ===================================*/
    "app_mode" => env("APP_MODE", 'dev'),

    /*===================================
    *  Adminr panel route prefix
    * -----------------------------------
    * Configure the prefix for admin panel
    * routes it will be used as the
    * name and as an endpoint for entire admin panel
    ===================================*/
    "route_prefix" => env('ADMINR_ROUTE_PREFIX', 'adminr'),
];
