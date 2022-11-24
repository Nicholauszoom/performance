<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('position_ref');
            $table->string('name', 100);
            $table->string('description', 300)->default('N/A');
            $table->string('type', 10)->default('IND');
            $table->bigInteger('amount');
            $table->boolean('mandatory')->default(1);
            $table->string('created_by', 10);
            $table->integer('isActive')->default(1);
            $table->dateTime('dated')->default('current_timestamp()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
