<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 4)->default('0');
            $table->string('street', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('location_code', 50)->nullable();
            $table->string('location_id', 50)->nullable();
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
        Schema::dropIfExists('branch');
    }
}
