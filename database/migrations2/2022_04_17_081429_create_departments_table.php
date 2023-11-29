<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('department');

        Schema::create('department', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dept_no');
            $table->integer('code')->default(1);
            $table->string('name');
            $table->string('cost_center_id');
            $table->string('company');
            $table->integer('type')->default(1)->comment("1-Department, 2-Subdepartment");
            $table->integer('hod')->nullable();
            $table->integer('reports_to')->default(3);
            $table->integer('state')->default(1);
            $table->string('department_pattern');
            $table->string('parent_pattern');
            $table->integer('level')->default(1);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('tbl_departments');
    }
}
