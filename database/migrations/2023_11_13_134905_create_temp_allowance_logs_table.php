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
        Schema::create('temp_allowance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10);
            $table->integer('allowanceID')->default(0);
            $table->integer('allowanceCode')->default(0);
            $table->string('description', 50)->default('Unclassified');
            $table->string('policy', 50)->default('Fixed Amount');
            $table->decimal('amount', 20)->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
            $table->string('benefit_in_kind')->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_allowance_logs');
    }
};
