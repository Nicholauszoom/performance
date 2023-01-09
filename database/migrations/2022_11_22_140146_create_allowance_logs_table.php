<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllowanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowance_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10);
            $table->integer('allowanceID')->default(6);
            $table->string('description', 50)->default('Unclassified');
            $table->string('policy', 50)->default('Fixed Amount');
            $table->decimal('amount', 20, 2)->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('allowance_logs');
    }
}
