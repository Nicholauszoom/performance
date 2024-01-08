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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(1)->comment('1-Financial Group(Allowances, Bonuses and Deductions), 2-Role Group');
            $table->string('name', 50);
            $table->unsignedInteger('grouped_by')->nullable()->comment('1.by employee and 2.by role');
            $table->string('created_by', 10)->nullable();;
            $table->dateTime('created_on')->useCurrent();
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
        Schema::dropIfExists('groups');
    }
};
