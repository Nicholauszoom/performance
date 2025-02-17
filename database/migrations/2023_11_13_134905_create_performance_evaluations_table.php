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
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('pillar_id');
            $table->double('target');
            $table->double('achieved');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->string('actions')->default('N/A');
            $table->string('measures')->default('N/A');
            $table->string('results')->default('N/A');
            $table->double('rating')->default(0);
            $table->double('weighting')->default(0);
            $table->double('score')->default(0);
            $table->double('self_evaluation')->default(0);
            $table->double('manager_evaluation')->default(0);
            $table->string('strategy_type')->default('N/A');
            $table->string('empid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
