<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_months', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('payroll_date')->default('2019-09-28');
            $table->integer('state')->default(1);
            $table->double('wcf')->default(0.01);
            $table->double('sdl')->default(0.045);
            $table->string('init_author', 10);
            $table->string('recom_author', 110)->nullable();
            $table->string('appr_author', 10);
            $table->date('init_date');
            $table->string('recom_date', 110)->nullable();
            $table->date('appr_date');
            $table->integer('arrears')->default(0)->comment("0-No, 1-Yes");
            $table->integer('pay_checklist')->default(0)->comment("0-Not Ready, 1-Ready");
            $table->integer('email_status')->default(0)->comment("0-Not sent, 1-Sent");
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
        Schema::dropIfExists('payroll_months');
    }
}
