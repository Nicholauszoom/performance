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
            $table->string('employeeid');
            $table->unsignedBigInteger('department');
            $table->text('suspension')->nullable();
            $table->date('date_of_charge')->nullable();
            $table->mediumText('detail_of_charge')->nullable();
            $table->date('date_of_hearing')->nullable();
            $table->mediumText('detail_of_hearing')->nullable();
            $table->mediumText('findings')->nullable();
            $table->mediumText('recommended_sanctum')->nullable();
            $table->mediumText('final_decission')->nullable();
            $table->timestamps();
            $table->string('appeal_received_by')->nullable();
            $table->date('date_of_receiving_appeal')->nullable();
            $table->string('appeal_reasons')->nullable();
            $table->string('appeal_findings')->nullable();
            $table->string('appeal_outcomes')->nullable();
            $table->string('investigation_report')->nullable();
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
