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
        Schema::create('company_property', function (Blueprint $table) {
            $table->id();
            $table->string('prop_type', 100)->nullable();
            $table->string('prop_name', 100)->nullable();
            $table->string('serial_no', 100)->nullable();
            $table->string('given_to', 10)->index('employee_fk');
            $table->string('given_by', 10)->nullable()->index('given_by');
            $table->dateTime('dated_on');
            $table->integer('isActive')->default(1);
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
        Schema::dropIfExists('company_property');
    }
};
