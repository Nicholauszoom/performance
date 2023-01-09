<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_overtime', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10)->index('empID');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->integer('overtime_type')->default(0)->comment("0-Day, 1-Night");
            $table->integer('overtime_category');
            $table->string('reason', 300);
            $table->string('final_line_manager_comment', 200);
            $table->string('remarks', 200);
            $table->dateTime('application_time');
            $table->integer('status')->comment("0-requested, 1-recommended, 2-approved by HR, 3-Held by Line Manager, 4-Denied By HR, 5-Confirmed by line");
            $table->string('linemanager', 10)->nullable();
            $table->string('hr', 10);
            $table->dateTime('time_recommended_line');
            $table->date('time_approved_hr');
            $table->dateTime('time_confirmed_line');
            $table->string('cd', 110);
            $table->string('time_approved_cd', 110);
            $table->string('finance', 110);
            $table->string('time_approved_fin', 110);
            $table->integer('commit')->default(0);
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
        Schema::dropIfExists('employee_overtime');
    }
}
