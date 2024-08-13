<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('activation_deactivation', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10);
            $table->integer('state')->comment('0-Deactivated, 1-Activated, 2-Request for Activation, 3-Request for Deactivation');
            $table->integer('current_state')->default(0)->comment('0-active, 1-committed');
            $table->integer('notification')->default(1)->comment('0-seen, 1-not seen');
            $table->dateTime('dated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('author', 10);
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
        Schema::dropIfExists('activation_deactivation');
    }
};
