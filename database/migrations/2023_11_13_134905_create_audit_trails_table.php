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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->increments('id');
            $table->bigstring('emp_id');
            $table->string('emp_name');
            $table->string('action_performed');
            $table->string('ip_address', 45);
            $table->string('user_agent');
            $table->integer('risk')->nullable()->comment('1-High, 2-Medium, 3-Low');
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
        Schema::dropIfExists('audit_trails');
    }
};
