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
        Schema::create('bonus', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10);
            $table->decimal('amount', 15);
            $table->integer('name');
            $table->string('init_author', 10)->nullable();
            $table->string('appr_author', 10)->nullable();
            $table->string('recom_author', 110);
            $table->integer('state')->comment('0-set,1-approved, 2-recommended');
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
        Schema::dropIfExists('bonus');
    }
};
