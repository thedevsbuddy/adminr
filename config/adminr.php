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

    /*===================================
    *  Adminr panel cache remember time
    * -----------------------------------
    * Configure the time in seconds to make
    * cache remember in system
    ===================================*/
    "cache_remember_time" => env('ADMINR_CACHE_REMEMBER_TIME', 60 * 60 * 24 * 30 * 12), // In seconds [1 Year by default]
];
