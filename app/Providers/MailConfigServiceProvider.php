<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public
    function boot()
    {
        if (Schema::hasTable('settings')) {
            $config = array(
                'driver' => getSetting('mail_driver'),
                'host' => getSetting('mail_host'),
                'port' => getSetting('mail_port'),
                'from' => array('address' => getSetting('mail_from_email'), 'name' => getSetting('mail_from_name')),
                'encryption' => getSetting('mail_encryption'),
                'username' => getSetting('mail_username'),
                'password' => getSetting('mail_password'),
            );
            $mailConfig = array_merge(config('mail'), $config);
            Config::set('mail', $mailConfig);
        }
    }
}
