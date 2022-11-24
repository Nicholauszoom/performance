<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_application', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('empID', 11)->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('leave_address', 50)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('nature', 50)->default('1');
            $table->string('reason', 500)->nullable();
            $table->integer('status')->default(0)->comment("0-Sent, 1-Recommended, 2-Approved, 3-Held, 4-Cancelled, 5-Disapproved by HR");
            $table->string('remarks')->nullable();
            $table->integer('notification')->default(2)->comment("0-seen, 1-Employee, 2-line manager, 3-hr approve, 4-seen by employee waiting hr");
            $table->date('application_date')->nullable();
            $table->string('approved_by_hr', 15)->nullable();
            $table->date('approved_date_hr')->nullable();
            $table->string('approved_by_line', 15)->nullable();
            $table->date('approved_date_line')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_application');
    }
}
