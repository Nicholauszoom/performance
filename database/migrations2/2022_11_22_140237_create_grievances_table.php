<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrievancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grievances', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10);
            $table->string('title', 200)->default('N/A');
            $table->string('description', 500)->nullable();
            $table->string('attachment', 200)->nullable();
            $table->integer('forwarded')->default(0);
            $table->string('support_document', 100)->default('N/A');
            $table->string('remarks', 200)->default('N/A');
            $table->string('recommendations', 500)->nullable();
            $table->string('forwarded_by', 10)->nullable();
            $table->dateTime('forwarded_on');
            $table->integer('status')->default(0)->comment("1-solved, 0-Not Solved");
            $table->integer('anonymous')->default(0);
            $table->timestamp('timed');
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
        Schema::dropIfExists('grievances');
    }
}
