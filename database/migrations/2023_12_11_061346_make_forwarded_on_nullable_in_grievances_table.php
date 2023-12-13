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
      
            Schema::table('grievances', function (Blueprint $table) {
                // Make the 'forwarded_on' column nullable
                $table->dateTime('forwarded_on')->nullable()->change();
            });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grievances', function (Blueprint $table) {
            //
        });
    }
};
