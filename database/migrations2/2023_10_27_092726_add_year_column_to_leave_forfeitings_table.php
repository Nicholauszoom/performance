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
        Schema::table('leave_forfeitings', function (Blueprint $table) {
            $table->string('forfeiting_year')->nullable(); // Add 'nature' column
            $table->string('opening-balance-year')->nullable(); // Add 'nature' column
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
