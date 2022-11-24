<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_list', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10);
            $table->string('initiator', 50);
            $table->string('reason', 500);
            $table->date('date_confirmed');
            $table->string('confirmed_by', 10);
            $table->date('exit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exit_list');
    }
}
