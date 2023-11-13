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
        Schema::create('emp_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userID', 10)->nullable();
            $table->integer('role')->nullable()->index('role');
            $table->integer('group_name')->default(0);
            $table->dateTime('duedate');
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
        Schema::dropIfExists('emp_role');
    }
};
