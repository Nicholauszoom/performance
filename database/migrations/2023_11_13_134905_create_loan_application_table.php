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
        Schema::create('loan_application', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 10)->nullable();
            $table->string('type', 100)->nullable()->comment('1-Salary Advance, 2-Forced Payments, 3-HESLB');
            $table->string('form_four_index_no', 20)->default('0');
            $table->decimal('amount', 15)->nullable();
            $table->decimal('deduction_amount', 15)->default(0);
            $table->string('reason', 200)->nullable();
            $table->date('application_date')->nullable();
            $table->string('status', 2)->default('0')->comment('0-Sent, 1-Recommended, 2-Approved, 3-Held, 4-Cancelled, 5-Disapproved ');
            $table->string('approved_hr', 50)->nullable();
            $table->string('approved_finance', 50)->nullable();
            $table->string('reason_hr', 50)->nullable();
            $table->string('reason_finance', 200)->nullable();
            $table->date('approved_date_hr')->nullable();
            $table->date('approved_date_finance')->nullable();
            $table->integer('notification')->default(2)->comment('0-seen, 1-Employee, 2-hr recommend, 3-Finance Approve, 4-seen by employee waiting finance');
            $table->string('time_approved_cd', 110);
            $table->string('approved_cd', 110);
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
        Schema::dropIfExists('loan_application');
    }
};
