<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditPurgeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_purge_logs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 10)->nullable();
            $table->string('description', 200)->nullable();
            $table->string('agent', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->dateTime('due_date')->nullable();
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
        Schema::dropIfExists('audit_purge_logs');
    }
}
