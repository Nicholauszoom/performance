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
        Schema::create('sick_leave_forfeit_days', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->double('forfeit_days');
            $table->timestamps();
            $table->unsignedBigInteger('leaveId')->nullable();
            $table->unsignedBigInteger('appliedBy')->nullable();
            $table->string('nature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sick_leave_forfeit_days');
    }
};