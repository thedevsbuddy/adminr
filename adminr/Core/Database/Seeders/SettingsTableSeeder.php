<?php

namespace Adminr\Core\Database\Seeders;

use Adminr\Core\Models\Setting;

class SettingsTableSeeder
{

    public function run(): void
    {
        Setting::firstOrCreate([
            "option" => "app_name",
            "value" => "AdminR"
        ]);

        Setting::firstOrCreate([
            "option" => "app_tagline",
            "value" => "Generate CRUDs within minutes."
        ]);

        Setting::firstOrCreate([
            "option" => "meta_title",
            "value" => "AdminR - Simple yet powerful admin panel crud generator."
        ]);

        Setting::firstOrCreate([
            "option" => "meta_description",
            "value" => "A simple yet powerful Admin panel with a CRUD generator built on laravel to help you build applications faster."
        ]);
        Setting::firstOrCreate([
            "option" => "title_separator",
            "value" => "-"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_from_name",
            "value" => "AdminR"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_from_email",
            "value" => "adminr@devsbuddy.com"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_driver",
            "value" => "smtp"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_encryption",
            "value" => "tls"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_host",
            "value" => "smtp.mailtrap.io"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_port",
            "value" => "2525"
        ]);
        Setting::firstOrCreate([
            "option" => "mail_queue_enabled",
            "value" => "1"
        ]);
        Setting::firstOrCreate([
            "option" => "email_verification_enabled",
            "value" => "1"
        ]);
    }
}
