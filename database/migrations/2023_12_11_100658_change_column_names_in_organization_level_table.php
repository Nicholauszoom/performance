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
        Schema::table('organization_level', function (Blueprint $table) {
            $table->renameColumn('minSalary', 'minsalary');
            $table->renameColumn('maxSalary', 'maxsalary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('organization_level', function (Blueprint $table) {
        //     $table->renameColumn('minsalary', 'minSalary');
        //     $table->renameColumn('maxsalary', 'maxSalary');
        // });
    }
};
