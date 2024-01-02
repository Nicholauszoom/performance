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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('employeeid');
            $table->double('oldsalary')->nullable();
            $table->double('newsalary');
            $table->integer('oldlevel')->nullable();
            $table->integer('newlevel')->nullable();
            $table->integer('oldposition')->nullable();
            $table->integer('newposition')->nullable();
            $table->string('action');
            $table->integer('created_by');
            $table->timestamps();
            $table->string('status')->default('pending');
            $table->string('effective_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};
