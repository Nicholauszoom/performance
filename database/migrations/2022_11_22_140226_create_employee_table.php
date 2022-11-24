<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('emp_id', 10)->unique('emp_id');
            $table->string('old_emp_id', 110)->default('0');
            $table->string('password_set', 10)->default('0');
            $table->string('fname', 20)->nullable();
            $table->string('mname', 20)->nullable();
            $table->string('lname', 20)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('nationality', 5)->default('255');
            $table->string('merital_status', 20)->nullable();
            $table->date('hire_date')->nullable();
            $table->integer('department')->nullable()->index('department_fk');
            $table->integer('position')->nullable()->index('positiont_fk');
            $table->string('branch', 5)->default('001');
            $table->integer('shift')->default(1);
            $table->integer('organization')->default(1)->comment("For Productivity Purpose");
            $table->string('line_manager', 50)->nullable();
            $table->string('contract_type', 100)->nullable();
            $table->date('contract_renewal_date')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->string('postal_address', 100)->nullable();
            $table->string('postal_city', 50)->default('Mwanza');
            $table->string('physical_address', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('photo', 100)->default('/uploads/userprofile/user.png');
            $table->integer('is_expatriate')->default(0)->comment("1-expatriate, 0-Normal");
            $table->string('home', 100)->nullable();
            $table->integer('bank');
            $table->integer('bank_branch');
            $table->string('account_no', 30)->nullable();
            $table->integer('pension_fund');
            $table->string('pf_membership_no', 20)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->integer('state')->default(1);
            $table->integer('login_user')->default(0)->comment("0-normal users, 1-user only to login no payment process");
            $table->date('last_updated')->nullable();
            $table->string('last_login', 20)->nullable();
            $table->integer('retired')->default(1);
            $table->date('contract_end')->nullable();
            $table->string('tin', 200)->nullable();
            $table->string('national_id', 200)->nullable();
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
}
