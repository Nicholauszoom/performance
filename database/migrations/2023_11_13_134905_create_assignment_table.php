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
        Schema::create('assignment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->string('project', 45);
            $table->string('activity', 45);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('description', 200)->nullable();
            $table->string('assigned_by', 45);
            $table->string('status', 45)->nullable();
            $table->string('progress', 45)->nullable();
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
        Schema::dropIfExists('assignment');
    }
};
