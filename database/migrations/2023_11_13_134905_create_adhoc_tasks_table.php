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
        Schema::create('adhoc_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('complete_date');
            $table->unsignedBigInteger('assigned')->nullable();
            $table->integer('status')->default(0);
            $table->double('target')->default(0);
            $table->double('achieved')->default(0);
            $table->double('time')->default(0);
            $table->double('behaviour')->default(0);
            $table->double('progress')->default(0);
            $table->text('remark')->nullable();
            $table->double('performance')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('adhoc_tasks');
    }
};
