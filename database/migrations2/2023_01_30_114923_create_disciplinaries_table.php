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
            $table->foreignId('department');
            $table->text('suspension')->nullable();
            $table->date('date_of_charge')->nullable();
            $table->mediumText('detail_of_charge')->nullable();
            $table->date('date_of_hearing')->nullable();
            $table->mediumText('detail_of_hearing')->nullable();
            $table->mediumText('findings')->nullable();
            $table->mediumText('recommended_sanctum')->nullable();
            $table->mediumText('final_decission')->nullable();
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
