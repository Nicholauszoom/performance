<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('overtimeID');
            $table->string('empID', 10);
            $table->dateTime('time_start')->default('current_timestamp()');
            $table->dateTime('time_end')->default('current_timestamp()');
            $table->decimal('amount', 15, 4);
            $table->string('linemanager', 10);
            $table->string('hr', 10);
            $table->dateTime('application_time')->default('current_timestamp()');
            $table->dateTime('confirmation_time')->default('current_timestamp()');
            $table->date('approval_time')->default('2019-06-19');
            $table->integer('status')->default(0)->comment("0-Waiting For Payment,1- Scheduled For Payment On Next Payroll");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtimes');
    }
}
