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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('code');
            $table->decimal('amount', 15)->default(0);
            $table->double('percent')->default(0);
            $table->integer('apply_to')->comment('1-apply to all, 2-apply to specific');
            $table->integer('mode')->default(1)->comment('1-fixed amount, 2-from basic salary, 3-from gross');
            $table->integer('state')->default(1)->comment('1-active, 0-inactive');
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
        Schema::dropIfExists('deductions');
    }
};
