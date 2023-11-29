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
        Schema::create('assignment_task', function (Blueprint $table) {
            $table->id();
            $table->integer('assignment_employee_id');
            $table->string('task_name', 200);
            $table->string('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('remarks', 200)->nullable();
            $table->string('status', 45)->default('0');
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
        Schema::dropIfExists('assignment_task');
    }
};
