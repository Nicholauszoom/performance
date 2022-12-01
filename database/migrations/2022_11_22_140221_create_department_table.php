<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('code')->default(0);
            $table->string('name', 100);
            $table->integer('type')->default(1)->comment("1-Department, 2-Subdepartment");
            $table->string('hod', 15)->nullable();
            $table->integer('reports_to')->default(3);
            $table->integer('state')->default(1);
            $table->string('department_pattern', 6);
            $table->string('parent_pattern', 6);
            $table->integer('level')->default(1);
            $table->string('created_by', 50)->nullable();
            $table->dateTime('created_on');
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
        Schema::dropIfExists('department');
    }
}
