<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnpaidLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('unpaid_leave', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('empID', 10);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->integer('state');
            $table->string('status');
            $table->timestamps(); // Created_at and Updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('unpaid_leave');
    }
}