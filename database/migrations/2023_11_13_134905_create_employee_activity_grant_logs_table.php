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
        Schema::create('employee_activity_grant_logs', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 45)->nullable();
            $table->string('activity_code', 45)->nullable();
            $table->string('grant_code', 45)->nullable();
            $table->string('percent', 45)->nullable();
            $table->string('isActive', 45)->nullable();
            $table->string('payroll_date', 45)->nullable();
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
        Schema::dropIfExists('employee_activity_grant_logs');
    }
};
