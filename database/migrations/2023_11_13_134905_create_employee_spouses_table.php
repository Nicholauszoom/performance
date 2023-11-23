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
        Schema::create('employee_spouses', function (Blueprint $table) {
            $table->id();
            $table->string('employeeid');
            $table->string('spouse_fname')->nullable();
            $table->string('spouse_birthdate')->nullable();
            $table->string('spouse_birthplace')->nullable();
            $table->string('spouse_birthcountry')->nullable();
            $table->string('spouse_nationality')->nullable();
            $table->string('spouse_nida')->nullable();
            $table->string('spouse_passport')->nullable();
            $table->string('spouse_employer')->nullable();
            $table->string('spouse_job_title')->nullable();
            $table->string('spouse_medical_aid')->nullable();
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
        Schema::dropIfExists('employee_spouses');
    }
};
