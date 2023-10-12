<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensionFundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pension_fund', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->double('amount_employee')->comment("Employee Amount in percent");
            $table->double('amount_employer')->comment("Employer Amount in percent");
            $table->integer('deduction_from')->comment("1-from Basic Salary, 2-From Gross");
            $table->integer('code');
            $table->string('abbrv', 10);
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
        Schema::dropIfExists('pension_fund');
    }
}
