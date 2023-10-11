<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funder', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 50);
            $table->string('phone', 15);
            $table->string('description', 200)->nullable();
            $table->dateTime('createdOn');
            $table->string('createdBy', 10);
            $table->string('status', 45)->default('1');
            $table->string('country', 25)->nullable();
            $table->string('type', 100)->nullable();
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
        Schema::dropIfExists('funder');
    }
}
