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
        Schema::table('performance_evaluations', function (Blueprint $table) {
            //

            $table->text('actions')->default('N/A');
            $table->text('measures')->default('N/A');
            $table->text('results')->default('N/A');
            $table->double('rating')->default('0');
            $table->double('weighting')->default('0');
            $table->double('score')->default('0');
            $table->double('self_evaluation')->default('0');
            $table->double('manager_evaluation')->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('performance_evaluations', function (Blueprint $table) {
            //
        });
    }
};
