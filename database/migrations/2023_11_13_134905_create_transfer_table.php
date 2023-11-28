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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10);
            $table->string('parameter', 100);
            $table->integer('parameterID')->comment('1-Salary, 2-Position, 3-Deptment, 4-Branch, 5-');
            $table->decimal('old', 15);
            $table->decimal('new', 15);
            $table->string('old_department', 5)->default('0');
            $table->string('new_department', 5)->default('0');
            $table->string('old_position', 5)->default('0');
            $table->string('new_position', 5)->default('0');
            $table->integer('status')->default(0)->comment('0-Requested, 1-Accepted, 2-Rejected');
            $table->string('recommended_by', 10);
            $table->string('approved_by', 10);
            $table->date('date_recommended');
            $table->date('date_approved');
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
        Schema::dropIfExists('transfer');
    }
};
