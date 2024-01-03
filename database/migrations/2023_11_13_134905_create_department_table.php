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
        Schema::create('department', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dept_no')->nullable();
            $table->integer('code')->default(1);
            $table->string('name')->nullable();
            $table->integer('cost_center_id')->unsigned();

            // $table->string('cost_center_id');
            $table->string('company')->nullable();
            $table->integer('type')->default(1)->comment('1-Department, 2-Subdepartment');
            $table->string('hod')->nullable();
            $table->integer('reports_to')->default(3);
            $table->integer('state')->default(1);
            $table->string('department_pattern')->nullable();
            $table->string('parent_pattern')->nullable();
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
        Schema::dropIfExists('department');
    }
};
