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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('employeeid');
            $table->string('em_fname')->nullable();
            $table->string('em_mname')->nullable();
            $table->string('em_sname')->nullable();
            $table->string('em_relationship')->nullable();
            $table->string('em_occupation')->nullable();
            $table->string('em_phone')->nullable();
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
        Schema::dropIfExists('emergency_contacts');
    }
};
