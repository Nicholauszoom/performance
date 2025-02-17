<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmedTraineeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmed_trainee', function (Blueprint $table) {
            $table->id();
            $table->integer('skillsID');
            $table->string('empid', 10);
            $table->decimal('cost', 15, 2);
            $table->integer('status')->default(0)->comment("0-On Training, 1-Graduated, 2-Paused");
            $table->string('recommended_by', 10);
            $table->date('date_recommended')->default('2019-07-29');
            $table->string('approved_by', 10);
            $table->date('date_approved')->default('2019-07-29');
            $table->string('confirmed_by', 10);
            $table->date('date_confirmed')->default('2019-07-29');
            $table->date('application_date');
            $table->string('accepted_by', 10);
            $table->date('date_accepted');
            $table->string('certificate', 100);
            $table->string('remarks', 200);
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
        Schema::dropIfExists('confirmed_trainee');
    }
}
