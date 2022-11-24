<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imprest', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10);
            $table->string('title', 100);
            $table->string('description', 200);
            $table->date('start')->default('2019-07-21');
            $table->date('end')->default('2019-07-21');
            $table->integer('status')->default(0)->comment("0-Sent, 1-Recommended, 2-Approved, 3-Confirmed, 4-Retirement, 5-Confirm Retirement, 6- Disapproved, 7- Unconfirmed, 8-Not Retiredot Retired");
            $table->string('hr_recommend', 110);
            $table->string('date_hr_recommend', 110);
            $table->string('recommended_by', 10);
            $table->date('date_recommended');
            $table->string('approved_by', 10);
            $table->date('date_approved');
            $table->string('confirmed_by', 10)->default('2550001');
            $table->date('date_confirmed')->default('2019-10-05');
            $table->date('application_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imprest');
    }
}
