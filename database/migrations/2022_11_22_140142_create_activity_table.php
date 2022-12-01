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
        Schema::create('tbl_ctivity', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 200);
            $table->string('code', 50);
            $table->string('description', 200);
            $table->string('project_ref', 50);
            $table->date('activityDate');
            $table->time('startTime');
            $table->time('finishTime');
            $table->integer('isActive')->default(1);
            $table->dateTime('dateCreated');
            $table->string('createdBy', 10);
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
        Schema::dropIfExists('activity');
    }
}
