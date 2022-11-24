<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10)->index('empID');
            $table->decimal('salary', 15, 2)->nullable();
            $table->decimal('allowances', 15, 2)->default(0.00);
            $table->decimal('pension_employee', 15, 2)->nullable();
            $table->decimal('pension_employer', 15, 2)->nullable();
            $table->decimal('medical_employee', 15, 2)->default(0.00);
            $table->decimal('medical_employer', 15, 2)->default(0.00);
            $table->decimal('taxdue', 15, 2)->nullable();
            $table->decimal('meals', 15, 2)->default(0.00);
            $table->integer('department');
            $table->integer('position');
            $table->integer('branch');
            $table->string('pension_fund', 100);
            $table->string('membership_no', 20)->default('PSSF/2019/000910');
            $table->decimal('sdl', 15, 2);
            $table->decimal('wcf', 15, 2);
            $table->decimal('less_takehome', 15, 2)->default(0.00)->comment("0-Complete Take Home");
            $table->dateTime('due_date')->default('current_timestamp()');
            $table->date('payroll_date')->nullable();
            $table->integer('bank')->default(1);
            $table->integer('bank_branch')->default(1);
            $table->string('account_no', 20)->default('0128J092341550');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_logs');
    }
}
