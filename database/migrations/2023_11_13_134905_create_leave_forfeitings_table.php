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
        Schema::create('leave_forfeitings', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10);
            $table->string('nature', 10);
            $table->string('days', 10);
            $table->timestamps();
            $table->string('opening_balance')->nullable();
            $table->string('adjusted_days')->nullable();
            $table->string('forfeiting_year')->nullable();
            $table->string('opening_balance_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_forfeitings');
    }
};
