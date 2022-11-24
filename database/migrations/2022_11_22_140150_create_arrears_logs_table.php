<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrearsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrears_logs', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('arrear_id');
            $table->decimal('amount_paid', 15, 2);
            $table->string('init_by', 10);
            $table->string('confirmed_by', 10);
            $table->date('payment_date');
            $table->date('payroll_date')->comment("Payroll Month in Which This Arrears Payment Was done");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrears_logs');
    }
}
