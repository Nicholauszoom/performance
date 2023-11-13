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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('overtimeID');
            $table->string('empID', 10);
            $table->dateTime('time_start')->useCurrent();
            $table->dateTime('time_end')->useCurrent();
            $table->string('overtime_category');
            $table->decimal('amount', 15, 4);
            $table->string('linemanager', 10);
            $table->string('hr', 10);
            $table->dateTime('application_time')->useCurrent();
            $table->dateTime('confirmation_time')->useCurrent();
            $table->date('approval_time')->default('2019-06-19');
            $table->integer('status')->default(0)->comment('0-Waiting For Payment,1- Scheduled For Payment On Next Payroll');
            $table->double('days')->default(0);
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
        Schema::dropIfExists('overtimes');
    }
};
