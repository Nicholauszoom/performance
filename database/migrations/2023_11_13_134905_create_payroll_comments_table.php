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
        Schema::create('payroll_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payroll_date', 110)->nullable();
            $table->string('emp_id', 110)->nullable();
            $table->string('message', 110)->nullable();
            $table->string('type', 110)->nullable()->comment('1-approve, 0-cancel');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('payroll_comments');
    }
};
