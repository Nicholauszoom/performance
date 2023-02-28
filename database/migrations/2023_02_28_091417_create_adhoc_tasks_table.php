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
            $table->date('start_date');
            $table->foreignId('project_id');
            $table->foreignId('assigned')->nullable();
            $table->integer('status')->default(0);
            $table->double('target')->default(0);
            $table->double('achieved')->default(0);
            $table->text('remark')->nullable();
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
