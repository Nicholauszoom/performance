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
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname', 100)->nullable();
            $table->string('mname', 100)->nullable();
            $table->string('lname', 100)->nullable();
            $table->string('relationship', 100)->nullable();
            $table->string('postal_address', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('employee_fk', 10)->index('employee_fk');
            $table->string('physical_address', 100)->nullable();
            $table->string('office_no', 100)->nullable();
            $table->string('added_on', 12)->nullable();
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
        Schema::dropIfExists('next_of_kin');
    }
};
