<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // drop if a table already exists
        // prepare for updates
        Schema::dropIfExists('attribute_genders');

        Schema::create('attribute_genders', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('item_value');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_genders');
    }
};