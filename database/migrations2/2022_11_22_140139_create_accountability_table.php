<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountability', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('remarks', 300)->nullable();
            $table->integer('position_ref');
            $table->string('author', 10)->default('25500005');
            $table->double('weighting');
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
        Schema::dropIfExists('accountability');
    }
}
