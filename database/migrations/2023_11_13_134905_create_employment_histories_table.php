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
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeID');
            $table->string('hist_start')->nullable();
            $table->string('hist_end')->nullable();
            $table->string('hist_employer')->nullable();
            $table->string('hist_industry')->nullable();
            $table->string('hist_position')->nullable();
            $table->string('hist_status')->nullable();
            $table->text('hist_reason')->nullable();
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
        Schema::dropIfExists('employment_histories');
    }
};
