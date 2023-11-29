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
    { ///iwe employee_termination_allowance_logs
        Schema::create('employee_termination_allowances', function (Blueprint $table) {
                $table->id();
                $table->integer('termination_id');
                $table->string('emp_id', 10);
                $table->integer('allowance_id')->default(6)->nullable();
                $table->string('description', 50)->default('Unclassified')->nullable();
                $table->string('policy', 50)->default('Fixed Amount')->nullable();
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
        Schema::dropIfExists('employee_termination_allowances');
    }
};
