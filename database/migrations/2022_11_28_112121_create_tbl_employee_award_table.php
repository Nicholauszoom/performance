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
        Schema::create('tbl_employee_award', function (Blueprint $table) {
            $table->id();
            $table->string('award_name');
            $table->integer('user_id');
            $table->string('gift_item');
            $table->integer('award_amount');
            $table->string('award_date');
            $table->string('status');
            $table->integer('view');
            $table->date('given_date');
            $table->integer('added_by');
            $table->integer('approved_by');
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
        Schema::dropIfExists('tbl_employee_award');
    }
};
