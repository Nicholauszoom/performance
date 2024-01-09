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
        Schema::create('temp_payroll_logs', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10)->index();
            $table->double('salary')->nullable();
            $table->double('taxable_amount')->nullable();
            $table->double('excess_added')->nullable();
            $table->double('rate')->nullable();
            $table->double('allowances')->default(0);
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
            $table->dateTime('due_date')->useCurrent();
            $table->date('payroll_date')->nullable();
            $table->integer('bank')->default(1);
            $table->integer('bank_branch')->default(1);
            $table->string('account_no', 20)->default('0128J092341550');
            $table->decimal('less_takehome', 20)->default(0);
            $table->string('currency')->nullable();
            $table->string('years')->nullable();
            $table->double('actual_salary')->nullable();
            $table->double('gross')->nullable();
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
        Schema::dropIfExists('temp_payroll_logs');
    }
};
