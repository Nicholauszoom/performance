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
        Schema::create('payroll_logs', function (Blueprint $table) {
            $table->id();
            // $table->string('empID', 10)->index('empID');
            $table->double('salary')->nullable();
            $table->double('allowances')->default(0);
            $table->double('pension2')->default(0);
            $table->double('taxable_amount')->default(0);
            $table->double('gross')->default(0);
            $table->double('excess_added')->default(0);
            $table->double('pension_employee')->nullable();
            $table->double('pension_employer')->nullable();
            $table->double('medical_employee')->default(0);
            $table->double('medical_employer')->default(0);
            $table->double('taxdue')->nullable();
            $table->double('meals')->default(0);
            $table->integer('department');
            $table->integer('position');
            $table->integer('branch');
            $table->string('pension_fund', 100);
            $table->string('membership_no', 20)->default('PSSF/2019/000910');
            $table->double('sdl');
            $table->double('wcf');
            $table->double('less_takehome')->default(0)->comment('0-Complete Take Home');
            $table->dateTime('due_date')->useCurrent();
            $table->date('payroll_date')->nullable();
            $table->integer('bank')->default(1);
            $table->integer('bank_branch')->default(1);
            $table->string('account_no', 20)->default('0128J092341550');
            $table->double('rate')->nullable();
            $table->double('currency')->nullable();
            $table->string('years')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('receipt_date')->nullable();
            $table->double('actual_salary')->default(0);
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
        Schema::dropIfExists('payroll_logs');
    }
};
