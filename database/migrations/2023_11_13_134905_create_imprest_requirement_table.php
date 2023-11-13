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
        Schema::create('imprest_requirement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 200);
            $table->string('evidence', 200);
            $table->integer('imprestID');
            $table->decimal('initial_amount', 15);
            $table->decimal('final_amount', 15)->default(0);
            $table->decimal('retired_amount', 15)->default(0);
            $table->integer('status')->default(0)->comment('0-requested, 1-Approved, 2-Confirmed, 3-Retired, 4-Confirmed Retirement, 5-disapproved, 6-Not Confirmed, 7-Not Retired, 8-Not Confirmed Retirement');
            $table->date('due_date');
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
        Schema::dropIfExists('imprest_requirement');
    }
};
