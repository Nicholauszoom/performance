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
        Schema::create('once_off_deduction', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10);
            $table->string('description', 50)->default('Unclassified');
            $table->string('policy', 50)->default('Fixed Amount');
            $table->decimal('paid', 15)->nullable();
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
        Schema::dropIfExists('once_off_deduction');
    }
};