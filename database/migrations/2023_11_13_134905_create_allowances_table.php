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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('code');
            $table->decimal('amount', 15);
            $table->double('percent', 10, 3)->default(0);
            $table->string('taxable', 50);
            $table->string('pensionable', 50);
            $table->string('Isrecursive', 50);
            $table->string('Isbik', 50);
            $table->string('type', 50)->default('1')->comment('1-anual leave allowance, 0.normal allowance');
            $table->integer('mode')->default(1)->comment('1-fixed value, 2-percent value depending basic salary');
            $table->integer('apply_to')->default(0)->comment('1-apply to all, 2-apply to specific');
            $table->integer('state')->default(1)->comment('1-active, 0-inactive');
            $table->string('temporary', 50);
            $table->string('created_by', 10)->nullable();
            $table->dateTime('created_on');
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
        Schema::dropIfExists('allowances');
    }
};
