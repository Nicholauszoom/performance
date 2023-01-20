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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->integer('employeeID');
            $table->double('oldSalary')->nullable();
            $table->double('newSalary');
            $table->integer('oldLevel')->nullable();
            $table->integer('newLevel')->nullable();
            $table->integer('oldPosition')->nullable();
            $table->integer('newPosition')->nullable();
            $table->string('action');
            $table->integer('created_by');
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
        Schema::dropIfExists('promotions');
    }
};
