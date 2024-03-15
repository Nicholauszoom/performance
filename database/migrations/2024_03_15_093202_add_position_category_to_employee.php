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
        Schema::table('position', function (Blueprint $table) {
            $table->string('position_category')->nullable();
            $table->foreign('position_category')->references('id')->on('position_category')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropColumn('position_category');
        });
    }
};
