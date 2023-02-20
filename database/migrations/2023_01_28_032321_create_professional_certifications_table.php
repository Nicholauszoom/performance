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
        Schema::create('professional_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID');
            $table->string('cert_name');
            $table->string('cert_start');
            $table->string('cert_end');
            $table->string('cert_qualification');
            $table->string('cert_number');
            $table->string('cert_status');
            $table->string('certificate')->nullable();
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
        Schema::dropIfExists('professional_certifications');
    }
};
