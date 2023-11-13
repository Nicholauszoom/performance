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
        Schema::create('task_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('description', 100);
            $table->double('lower_limit');
            $table->double('upper_limit');
            $table->double('contribution');
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
        Schema::dropIfExists('task_ratings');
    }
};
