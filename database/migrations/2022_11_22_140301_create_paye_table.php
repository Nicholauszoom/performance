<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paye', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->decimal('minimum', 15, 2)->nullable();
            $table->decimal('maximum', 15, 2)->nullable();
            $table->double('rate', 4, 4)->nullable();
            $table->decimal('excess_added', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paye');
    }
}
