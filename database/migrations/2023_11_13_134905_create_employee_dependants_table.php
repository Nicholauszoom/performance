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
        Schema::create('employee_dependants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employeeID');
            $table->string('dep_name')->nullable();
            $table->string('dep_surname')->nullable();
            $table->string('dep_birthdate')->nullable();
            $table->string('dep_gender')->nullable();
            $table->string('dep_certificate')->nullable();
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
        Schema::dropIfExists('employee_dependants');
    }
};
