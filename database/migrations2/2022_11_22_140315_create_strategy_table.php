<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrategyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strategy', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('description', 670)->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('type')->default(1)->comment("1-strategy, 2-project");
            $table->integer('funder');
            $table->string('author', 10);
            $table->integer('status');
            $table->integer('progress');
            $table->dateTime('dated')->useCurrent();
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
        Schema::dropIfExists('strategy');
    }
}
