<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_budget', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('description', 100);
            $table->decimal('amount', 15, 2);
            $table->date('start')->default('2019-07-27');
            $table->date('end')->default('2019-07-27');
            $table->integer('status')->default(0)->comment("0-requested, 1-approved, 2-Denied");
            $table->string('recommended_by', 10);
            $table->date('date_recommended')->default('2019-07-26');
            $table->string('approved_by', 10);
            $table->date('date_approved')->default('2019-07-26');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_budget');
    }
}
