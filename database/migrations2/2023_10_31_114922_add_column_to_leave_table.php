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
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('revoke_reason')->nullable();
            $table->string('enddate_revoke')->nullable();
            $table->string('revoke_status')->nullable();
            $table->timestamp('revoke_created_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('le   ave', function (Blueprint $table) {
            //
        });
    }
};
