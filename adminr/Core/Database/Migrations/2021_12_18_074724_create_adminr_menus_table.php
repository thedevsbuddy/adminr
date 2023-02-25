<?php

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
        Schema::create('adminr_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent')->nullable();
            $table->string('label');
            $table->string('route');
            $table->boolean('active')->default(true)->comment('true | false');
            $table->enum('icon_type', ['icon', 'svg', 'image'])->nullable()->comment('icon | svg | image');
            $table->text('icon')->nullable();
            $table->unsignedBigInteger('resource')->nullable();
            $table->timestamps();

            $table->foreign('resource')->references('id')->on('adminr_resources')->cascadeOnDelete();
            $table->foreign('parent')->references('id')->on('adminr_menus')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adminr_menus');
    }
};
