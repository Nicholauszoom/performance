<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10);
            $table->dateTime('time_start')->default('current_timestamp()');
            $table->dateTime('time_end')->default('current_timestamp()');
            $table->decimal('amount', 15, 2);
            $table->string('linemanager', 10);
            $table->string('hr', 10);
            $table->dateTime('application_time')->default('current_timestamp()');
            $table->dateTime('confirmation_time')->default('current_timestamp()');
            $table->date('approval_time')->default('2019-06-19');
            $table->date('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtime_logs');
    }
}
