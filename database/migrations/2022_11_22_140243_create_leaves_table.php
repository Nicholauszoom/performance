<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('empID');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('days')->default(0);
            $table->string('leave_address', 50)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('nature', 50)->default('');
            $table->text('reason')->default('');
            $table->string('state', 1)->default('1')->comment("0-completed, 1-on progress");
            $table->date('application_date')->nullable();
            $table->string('approved_by', 10)->nullable();
            $table->string('recommended_by', 10)->nullable();
            $table->integer('sub_category')->nullable();
            $table->string('attachment')->default('');
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
        Schema::dropIfExists('leaves');
    }
}
