<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
            "value" => "A simple yet powerful Admin panel with CRUD generator built on laravel to help you build application faster."
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
    }
}
