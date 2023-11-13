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
        Schema::create('employee_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeID');
            $table->string('parent_names')->nullable();
            $table->string('parent_relation')->nullable();
            $table->string('parent_birthdate')->nullable();
            $table->string('parent_residence')->nullable();
            $table->string('parent_living_status')->nullable();
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
        Schema::dropIfExists('employee_parents');
    }
};
