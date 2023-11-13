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
        Schema::create('training_application_form', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname', 10);
            $table->string('mname,20');
            $table->string('lname', 10);
            $table->string('skill,20');
            $table->string('reason', 10);
            $table->string('location', 20);
            $table->string('budget', 10);
            $table->date('start_date')->default('2019-07-29');
            $table->date('end_date')->default('2019-07-29');
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
        Schema::dropIfExists('training_application_form');
    }
};
