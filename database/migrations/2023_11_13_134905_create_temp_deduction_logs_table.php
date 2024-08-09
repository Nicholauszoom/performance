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
        Schema::create('temp_deduction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10);
            $table->integer('deductionID')->default(0);
            $table->integer('deductionCode')->default(0);
            $table->string('description', 50)->default('Unclassified');
            $table->string('policy', 50)->default('Fixed Amount');
            $table->bigInteger('paid')->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('temp_deduction_logs');
    }
};
