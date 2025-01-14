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
        Schema::create('temp_loan_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('loanID');
            $table->integer('loanTypeID')->nullable()->default(0);
            $table->integer('loanCode')->nullable()->default(0);
            $table->double('policy')->default(0);
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('remained')->nullable();
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
};
