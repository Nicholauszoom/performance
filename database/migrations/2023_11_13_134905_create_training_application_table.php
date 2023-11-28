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
        Schema::create('training_application', function (Blueprint $table) {
            $table->id();
            $table->integer('skillsID');
            $table->string('empid', 10);
            $table->integer('status')->default(0)->comment('0-requested, 1-recommended, 2-approved by HR, 3-Confirmed By Finance, 4-Held by Line Manager, 5-Dissaproved, 6-Unconfirmed, 7-Cancelled Employee');
            $table->string('recommended_by', 10);
            $table->date('date_recommended')->default('2019-07-29');
            $table->string('approved_by', 10);
            $table->date('date_approved')->default('2019-07-29');
            $table->string('confirmed_by', 10);
            $table->date('date_confirmed')->default('2019-07-29');
            $table->date('application_date');
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
        Schema::dropIfExists('training_application');
    }
};
