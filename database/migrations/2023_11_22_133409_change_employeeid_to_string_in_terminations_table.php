<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEmployeeIdToStringInTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->string("employeeID")->change();
            // $table->renameColumn('employeeID', 'employid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terminations', function (Blueprint $table) {
            $table->unsignedBigInteger('employeeID')->change();
        });
    }
}
