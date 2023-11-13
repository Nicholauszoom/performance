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
        Schema::table('roles_sys_modules', function (Blueprint $table) {
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onDelete('CASCADE');
            $table->foreign(['sys_module_id'])->references(['id'])->on('sys_modules')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles_sys_modules', function (Blueprint $table) {
            $table->dropForeign('roles_sys_modules_role_id_foreign');
            $table->dropForeign('roles_sys_modules_sys_module_id_foreign');
        });
    }
};
