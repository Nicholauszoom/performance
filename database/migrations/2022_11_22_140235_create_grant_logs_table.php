<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrantLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grant_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('funder', 45);
            $table->string('project', 45);
            $table->string('activity', 45);
            $table->string('mode', 45);
            $table->decimal('amount', 20, 2);
            $table->date('date')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('status', 45)->default('0');
            $table->string('created_by', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grant_logs');
    }
}
