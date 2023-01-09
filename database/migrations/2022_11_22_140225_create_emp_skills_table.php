<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_skills', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10);
            $table->integer('skill_ID');
            $table->string('certificate', 50)->nullable();
            $table->string('remarks', 100)->nullable();
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
        Schema::dropIfExists('emp_skills');
    }
}
