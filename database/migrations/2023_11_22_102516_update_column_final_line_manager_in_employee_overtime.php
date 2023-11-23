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
        Schema::table('employee_overtime', function (Blueprint $table) {
            $table->string('final_line_manager_comment', 200)->nullable()->change();
            $table->string('remarks', 200)->nullable()->change();
            $table->string('hr', 10)->nullable()->change();
            $table->string('cd', 110)->nullable()->change();
            $table->string('time_approved_cd', 110)->nullable()->change();
            $table->string('finance', 110)->nullable()->change();
            $table->string('time_approved_fin', 110)->nullable()->change();
            $table->integer('status')->comment('0-requested, 1-recommended, 2-approved by HR, 3-Held by Line Manager, 4-Denied By HR, 5-Confirmed by line')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employee_overtime', function (Blueprint $table) {
            $table->string('final_line_manager_comment', 200)->nullable(false)->change();
            $table->string('remarks', 200)->nullable()->change();
            $table->string('hr', 10)->nullable()->change();
            $table->string('cd', 110)->nullable()->change();
            $table->string('time_approved_cd', 110)->nullable()->change();
            $table->string('finance', 110)->nullable()->change();
            $table->string('time_approved_fin', 110)->nullable()->change();
            $table->integer('status')->comment('0-requested, 1-recommended, 2-approved by HR, 3-Held by Line Manager, 4-Denied By HR, 5-Confirmed by line')->nullable()->change();
        });
    }

};
