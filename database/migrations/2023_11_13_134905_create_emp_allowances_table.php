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
        Schema::create('emp_allowances', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10);
            $table->integer('allowance')->index('package');
            $table->string('mode', 10)->comment('1-fixed value 2-percent');
            $table->integer('group_name')->default(0);
            $table->string('percent', 10);
            $table->string('amount', 10);
            $table->string('currency', 10);
            $table->string('rate', 10);
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
        Schema::dropIfExists('emp_allowances');
    }
};
