<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrears', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('empID', 10);
            $table->decimal('amount', 15, 2);
            $table->decimal('paid', 15, 2)->default(0.00);
            $table->decimal('amount_last_paid', 15, 2)->default(0.00);
            $table->date('last_paid_date');
            $table->date('payroll_date');
            $table->integer('status')->default(1)->comment("0-Payment Completed, 1-Payment Not Completed");
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
        Schema::dropIfExists('arrears');
    }
}