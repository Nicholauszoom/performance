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
        Schema::create('emp_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('empID', 50);
            $table->integer('deduction');
            $table->integer('group_name')->default(0)->comment('0- For individual');
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
        Schema::dropIfExists('emp_deductions');
    }
};
