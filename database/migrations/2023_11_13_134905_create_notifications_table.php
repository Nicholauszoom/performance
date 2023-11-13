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
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('role', 110);
            $table->integer('type')->comment('0-overtime, 1-imprest,2-payroll,3-avd_salary, 4-incentives');
            $table->string('message', 110);
            $table->integer('for');
            $table->string('recom_by', 110)->nullable();
            $table->id();
            $table->timestamps();

            $table->unique(['type', 'for'], 'unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
