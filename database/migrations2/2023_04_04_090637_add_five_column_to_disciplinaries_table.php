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
            //
            $table->string('appeal_received_by');
            $table->date('date_of_receiving_appeal');
            $table->string('appeal_reasons');
            $table->string('appeal_findings');
            $table->string('appeal_outcomes');
            $table->string('investigation_report');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discplinaries', function (Blueprint $table) {
            //
        });
    }
};
