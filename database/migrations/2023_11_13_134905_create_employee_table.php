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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id', 10);
            $table->string('company')->nullable();
            $table->string('old_emp_id', 110);
            $table->string('password_set', 10);
            $table->string('full_name');
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('nationality');
            $table->string('merital_status')->nullable();
            $table->date('hire_date')->nullable();
            $table->integer('department')->nullable();
            $table->integer('position')->nullable();
            $table->string('job_title')->nullable();
            $table->string('branch', 5)->default('001');
            $table->integer('shift')->default(1);
            $table->integer('organization')->default(1);
            $table->string('line_manager')->nullable();
            $table->string('contract_type')->nullable();
            $table->date('contract_renewal_date')->nullable();
            $table->double('salary', 15)->nullable();
            $table->string('currency')->nullable();
            $table->decimal('rate', 10)->nullable();
            $table->string('postal_address')->nullable();
            $table->string('postal_city', 50)->nullable()->default('Mwanza');
            $table->string('physical_address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('photo', 100)->nullable()->default('/uploads/userprofile/user.png');
            $table->integer('is_expatriate')->default(0);
            $table->string('home')->nullable();
            $table->integer('payroll_no')->nullable();
            $table->string('emp_level')->nullable();
            $table->integer('bank')->nullable();
            $table->integer('bank_branch')->nullable();
            $table->string('account_no')->nullable();
            $table->integer('pension_fund')->nullable();
            $table->string('pf_membership_no')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->integer('state')->default(1);
            $table->integer('login_user')->default(0);
            $table->date('last_updated')->nullable();
            $table->string('last_login', 20)->nullable();
            $table->integer('retired')->default(1);
            $table->date('contract_end')->nullable();
            $table->string('contracted_month')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('heslb_balance')->nullable();
            $table->string('form_4_index')->nullable();
            $table->string('unpaid_leave')->nullable();
            $table->string('leave_days_entitled')->nullable();
            $table->string('accrual_rate')->nullable();
            $table->string('tin')->nullable();
            $table->string('national_id')->nullable();
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
        Schema::dropIfExists('employee');
    }
};
