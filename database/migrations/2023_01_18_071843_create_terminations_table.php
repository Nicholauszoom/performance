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
        Schema::create('terminations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID');
            $table->date('terminationDate');
            $table->text('reason');
            $table->double('salaryEnrollment');
            $table->double('normalDays');
            $table->double('publicDays');
            $table->double('noticePay');
            $table->double('leavePay');
            $table->double('livingCost');
            $table->double('houseAllowance');
            $table->double('utilityAllowance');
            $table->double('leaveAllowance');
            $table->double('tellerAllowance');
            $table->double('serevancePay');
            $table->double('leaveStand');
            $table->double('arrears');
            $table->double('exgracia');
            $table->double('bonus');
            $table->double('longServing');
            $table->double('salaryAdvance');
            $table->double('otherDeductions')->nullable();
            $table->double('otherPayments')->nullable();
            
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
        Schema::dropIfExists('terminations');
    }
};
