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
        Schema::table('employee', function (Blueprint $table) {
            $table->string('device_token')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn('device_token');
        });
    }
};
