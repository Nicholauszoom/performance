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
       

       Schema::table('audit_trails', function (Blueprint $table) {
            $table->string('emp_id')->nullable()->change();
            $table->string('emp_name')->nullable()->change();
            $table->string('action_performed')->nullable()->change();
            $table->string('ip_address', 45)->nullable()->change();
            $table->string('user_agent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
