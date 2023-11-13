<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_forfeitings', function (Blueprint $table) {
            $table->string('new_opening_balance_year')->nullable();
        });

        DB::statement('UPDATE leave_forfeitings SET new_opening_balance_year = `opening-balance-year`');

        Schema::table('leave_forfeitings', function (Blueprint $table) {
            $table->dropColumn('opening-balance-year');
            $table->renameColumn('new_opening_balance_year', 'opening_balance_year');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_forfeitings', function (Blueprint $table) {
            //
        });
    }
};
