<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSickLeaveForfeitDaysTable extends Migration
{
    public function up()
    {
        Schema::create('sick_leave_forfeit_days', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); // Define emp_id with the same data type and length as the employee table.
            $table->integer('forfeit_days');
            $table->timestamps();

           
        });
    }

    public function down()
    {
        Schema::dropIfExists('sick_leave_forfeit_days');
    }
}
