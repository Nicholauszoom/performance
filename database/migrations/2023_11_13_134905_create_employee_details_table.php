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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employeeID');
            $table->string('maide_name')->nullable();
            $table->string('religion')->nullable();
            $table->string('prefix')->nullable();
            $table->string('marriage_date')->nullable();
            $table->string('divorced_date')->nullable();
            $table->string('former_title')->nullable();
            $table->string('landmark')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('birthcountry')->nullable();
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
        Schema::dropIfExists('employee_details');
    }
};
