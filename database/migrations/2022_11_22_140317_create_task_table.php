<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('description', 1000);
            $table->string('title', 200)->default('N/A');
            $table->decimal('initial_quantity', 15, 2)->default(1.00);
            $table->decimal('submitted_quantity', 15, 2)->default(0.00);
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
            $table->integer('notification')->default(1)->comment("0-seen, 1-Employee, 2-line manager");
            $table->date('date_completed')->nullable();
            $table->string('attachment', 100)->default('0');
            $table->string('submission_remarks', 300)->nullable();
            $table->date('date_marked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
