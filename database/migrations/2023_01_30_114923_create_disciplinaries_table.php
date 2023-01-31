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
        Schema::create('disciplinaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID');
            $table->text('suspension');
            $table->date('date_of_charge');
            $table->mediumText('detail_of_charge');
            $table->date('date_of_hearing');
            $table->mediumText('detail_of_hearing');
            $table->mediumText('findings');
            $table->mediumText('recommended_sanctum');
            $table->mediumText('final_decission');
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
        Schema::dropIfExists('disciplinaries');
    }
};
