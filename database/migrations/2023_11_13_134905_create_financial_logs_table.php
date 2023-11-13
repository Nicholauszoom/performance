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
        Schema::create('financial_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payrollno');
            $table->string('changed_by');
            $table->string('field_name');
            $table->string('action_from');
            $table->string('action_to');
            $table->string('input_screen');
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
        Schema::dropIfExists('financial_logs');
    }
};
