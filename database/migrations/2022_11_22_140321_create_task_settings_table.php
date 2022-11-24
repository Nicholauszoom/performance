<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_settings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 100);
            $table->double('behaviour')->nullable();
            $table->double('quantity')->nullable();
            $table->double('value', 5, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_settings');
    }
}
