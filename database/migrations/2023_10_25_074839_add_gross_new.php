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

        $columnName = 'gross';
        $tableName = 'temp_payroll_logs';

        if (!Schema::hasColumn($tableName, $columnName)) {
            // The column exists in the table.

        Schema::table('temp_payroll_logs', function (Blueprint $table) {
            $table->double('gross')->default(0.00);
        });

    }
    }

    public function down()
    {
        Schema::table('temp_payroll_logs', function (Blueprint $table) {
            $table->dropColumn('gross');
        });
    }
};
