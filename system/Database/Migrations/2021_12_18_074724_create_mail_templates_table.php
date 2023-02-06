<?php

use Adminr\System\Database\Seeders\MailTemplateSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('purpose')->nullable();
            $table->string('code')->unique();
            $table->longText('content');
            $table->timestamps();
        });

        /// Run The seeder
        MailTemplateSeeder::run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
};
