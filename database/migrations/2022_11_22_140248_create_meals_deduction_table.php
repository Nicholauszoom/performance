<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsDeductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals_deduction', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 50);
            $table->double('minimum_gross');
            $table->double('maximum_payment');
            $table->double('minimum_payment');
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
        Schema::dropIfExists('meals_deduction');
    }
}
