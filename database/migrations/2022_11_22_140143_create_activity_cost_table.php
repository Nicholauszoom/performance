<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_cost', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('emp_id', 45)->nullable();
            $table->string('project', 45);
            $table->string('activity', 45);
            $table->string('assignment', 45);
            $table->string('cost_category', 45);
            $table->decimal('amount', 20, 2);
            $table->string('description', 200)->nullable();
            $table->string('document', 100)->nullable();
            $table->string('status', 45)->default('1');
            $table->string('created_by', 45);
            $table->string('approved_by', 45)->nullable();
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
        Schema::dropIfExists('activity_cost');
    }
}
