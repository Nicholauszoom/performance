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
        Schema::create('outcome', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->string('description', 500)->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('assigned_by', 10);
            $table->string('assigned_to', 10);
            $table->integer('isAssigned')->default(0);
            $table->integer('strategy_ref');
            $table->dateTime('dated');
            $table->string('author', 10);
            $table->string('indicator', 300)->nullable();
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
        Schema::dropIfExists('outcome');
    }
};
