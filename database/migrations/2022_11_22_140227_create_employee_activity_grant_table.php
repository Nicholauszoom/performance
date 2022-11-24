<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeActivityGrantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_activity_grant', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('empID', 10);
            $table->string('activity_code', 50);
            $table->string('grant_code', 50);
            $table->decimal('percent', 5, 2);
            $table->integer('isActive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_activity_grant');
    }
}
