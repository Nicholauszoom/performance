<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempLoanLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_loan_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('loanID');
            $table->integer('loanTypeID');
            $table->integer('loanCode');
            $table->double('policy')->default(0);
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('remained');
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
        Schema::dropIfExists('temp_loan_logs');
    }
}
