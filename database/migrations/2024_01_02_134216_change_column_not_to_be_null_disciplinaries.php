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
        Schema::table('disciplinaries', function (Blueprint $table) {
            $table->string('findings')->nullable()->change();
            $table->string('appeal_received_by')->nullable()->change();
            $table->string('appeal_reasons')->nullable()->change();
            $table->string('date_of_receiving_appeal')->nullable()->change();
            $table->string('appeal_findings')->nullable()->change();
            $table->string('appeal_outcomes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disciplinaries', function (Blueprint $table) {
            //
        });
    }
};
