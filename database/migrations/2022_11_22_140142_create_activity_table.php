<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 200);
            $table->string('code', 50);
            $table->string('description', 200);
            $table->string('project_ref', 50);
            $table->date('activityDate');
            $table->time('startTime');
            $table->time('finishTime');
            $table->integer('isActive')->default(1);
            $table->dateTime('dateCreated')->default('current_timestamp()');
            $table->string('createdBy', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity');
    }
}
