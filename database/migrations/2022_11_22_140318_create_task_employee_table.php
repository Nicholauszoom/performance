<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_employee', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('employeeID', 10);
            $table->integer('taskID');
            $table->dateTime('assignedOn');
            $table->string('assignedBy', 10);
            $table->integer('status')->default(1)->comment("1-Assigned, 0-Cancelled");
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
        Schema::dropIfExists('task_employee');
    }
}
