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
        Schema::table('acceleration_tasks', function (Blueprint $table) {
            $table->foreign(['acceleration_id'])->references(['id'])->on('accelerations')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acceleration_tasks', function (Blueprint $table) {
            $table->dropForeign('acceleration_tasks_acceleration_id_foreign');
        });
    }
};
