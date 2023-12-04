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
        Schema::create('terminations', function (Blueprint $table) {
            $table->id();
            $table->string('employeeID');
            $table->date('terminationDate');
            $table->string('reason');
            $table->decimal('salaryEnrollment', 10);
            $table->decimal('actual_salary', 10);
            $table->unsignedInteger('normalDays');
            $table->unsignedInteger('publicDays');
            $table->decimal('noticePay', 10);
            $table->decimal('leavePay', 10);
            $table->decimal('livingCost', 10);
            $table->decimal('houseAllowance', 10);
            $table->decimal('utilityAllowance', 10);
            $table->decimal('leaveAllowance', 10);
            $table->decimal('tellerAllowance', 10);
            $table->decimal('serevancePay', 10);
            $table->decimal('leaveStand', 10);
            $table->decimal('arrears', 10);
            $table->decimal('exgracia', 10);
            $table->decimal('bonus', 10);
            $table->decimal('total_gross', 10);
            $table->decimal('normal_days_overtime_amount', 10);
            $table->decimal('public_overtime_amount', 10);
            $table->decimal('longServing', 10);
            $table->decimal('salaryAdvance', 10);
            $table->decimal('loan_balance', 10);
            $table->decimal('otherDeductions', 10);
            $table->decimal('otherPayments', 10);
            $table->decimal('paye', 10);
            $table->boolean('taxable');
            $table->decimal('pension_employee', 10);
            $table->decimal('net_pay', 10);
            $table->decimal('take_home', 10);
            $table->decimal('total_deductions', 10);
            $table->timestamps();
            $table->string('status');
            $table->decimal('wcf', 10);
            $table->decimal('sdl', 10);
            $table->decimal('transport_allowance', 10);
            $table->decimal('nightshift_allowance', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terminations');
    }
};
