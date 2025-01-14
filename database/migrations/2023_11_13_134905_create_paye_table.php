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
        Schema::create('paye', function (Blueprint $table) {
            $table->id();
            $table->decimal('minimum', 15)->nullable();
            $table->decimal('maximum', 15)->nullable();
            $table->double('rate', 4, 4)->nullable();
            $table->decimal('excess_added', 15)->nullable();
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
        Schema::dropIfExists('paye');
    }
};
