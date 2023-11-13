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
        Schema::create('confirmed_imprest', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10);
            $table->integer('imprestID');
            $table->decimal('initial', 15);
            $table->decimal('final', 15);
            $table->integer('status')->default(0)->comment('1-resolved, 0-not resolved');
            $table->date('date_resolved');
            $table->date('date_confirmed');
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
        Schema::dropIfExists('confirmed_imprest');
    }
};
