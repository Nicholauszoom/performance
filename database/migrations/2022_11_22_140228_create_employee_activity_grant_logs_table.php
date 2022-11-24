<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeActivityGrantLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_activity_grant_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 45)->nullable();
            $table->string('activity_code', 45)->nullable();
            $table->string('grant_code', 45)->nullable();
            $table->string('percent', 45)->nullable();
            $table->string('isActive', 45)->nullable();
            $table->string('payroll_date', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_activity_grant_logs');
    }
}
