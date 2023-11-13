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
        Schema::create('activity_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('cost');
            $table->integer('target');
            $table->integer('result');
            $table->integer('emp_id');
            $table->integer('exactly_cost');
            $table->integer('activity_id');
            $table->integer('deliverable_id');
            $table->string('description', 100);
            $table->integer('state')->default(1);
            $table->integer('managed_by');
            $table->string('document', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('activity_results');
    }
};
