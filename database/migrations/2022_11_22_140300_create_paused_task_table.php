<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePausedTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paused_task', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('description', 1000);
            $table->string('title', 200)->default('N/A');
            $table->integer('initial_quantity')->default(1);
            $table->integer('submitted_quantity')->default(0);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('assigned_to', 50)->nullable();
            $table->string('assigned_by', 11)->nullable();
            $table->date('date_assigned')->nullable();
            $table->integer('progress')->default(0);
            $table->integer('outcome_ref');
            $table->integer('strategy_ref')->nullable();
            $table->integer('output_ref');
            $table->integer('status')->default(0)->comment("0-assigned, 1- Submitted, 2-approved, 3-Cancelled, 4-overdue, 5-disapproved, 6-committed");
            $table->double('quantity')->default(1);
            $table->integer('quantity_type')->default(2)->comment("1-finencial quantity, 2-numerical quantity");
            $table->double('quality')->default(1)->comment("behaviour");
            $table->double('excess_points')->default(0);
            $table->string('qb_ratio', 15)->default('70:30')->comment("quantity_behaviour Ratio");
            $table->integer('monetaryValue')->default(0);
            $table->string('remarks', 500)->nullable();
            $table->integer('isAssigned')->default(0);
            $table->integer('notification')->default(1);
            $table->date('date_completed')->nullable();
            $table->date('date_marked')->nullable();
            $table->date('date_paused');
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
        Schema::dropIfExists('paused_task');
    }
}
