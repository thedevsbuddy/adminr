<?php

use Adminr\Core\Database\Seeders\SettingsTableSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->text('value')->nullable();
            $table->timestamps();
        });

        /// Run The seeder
        (new SettingsTableSeeder)->run();
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
