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
<<<<<<< HEAD
        Schema::table('payroll_logs', function (Blueprint $table) {
          //  $table->timestamps();
        });
=======
        // Schema::table('payroll_logs', function (Blueprint $table) {
        //     $table->timestamps();
        // });
>>>>>>> main_join
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_logs', function (Blueprint $table) {
            //
        });
    }
};
