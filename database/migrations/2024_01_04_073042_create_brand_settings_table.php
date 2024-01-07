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
        Schema::create('brand_settings', function (Blueprint $table) {
            $table->id();

            $table->string('company_logo')->nullable();
            $table->string('report_logo')->nullable();
            $table->string('dashboard_logo')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('hover_color')->nullable();
            $table->string('hover_color_two')->nullable();
            $table->string('loader_color_one')->nullable();
            $table->string('loader_color_two')->nullable();
            $table->string('loader_color_three')->nullable();
            $table->string('loader_color_four')->nullable();
            $table->string('loader_color_five')->nullable();
            $table->string('loader_color_six')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('address_4')->nullable();
            $table->string('login_picture')->nullable();

            $table->string('body_background')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_settings');
    }
};
