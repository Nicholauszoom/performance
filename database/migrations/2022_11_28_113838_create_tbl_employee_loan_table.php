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
        Schema::create('tbl_employee_loan', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('loan_amount',20,2);
            $table->decimal('paid_amount',20,2);
            $table->string('sponsor');
            $table->string('deduct_month');
            $table->date('request_date');
            $table->string('reason');
            $table->integer('returns');
            $table->integer('status');
            $table->integer('approved_by');
            $table->integer('added_by');
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
        Schema::dropIfExists('tbl_employee_loan');
    }
};
