<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan', function (Blueprint $table) {
            $table->id();
            $table->string('empID', 10)->nullable();
            $table->string('description', 200);
            $table->integer('type')->comment("1-Salary Advance, 2-Forced Payments, 3-HESLB");
            $table->string('form_four_index_no', 20)->default('0');
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('deduction_amount', 15, 2);
            $table->date('application_date')->nullable();
            $table->integer('state')->default(1)->comment("0-approved");
            $table->string('approved_hr', 50)->nullable();
            $table->string('approved_finance', 50)->nullable();
            $table->date('approved_date_hr')->nullable();
            $table->date('approved_date_finance')->nullable();
            $table->decimal('paid', 15, 2)->nullable();
            $table->decimal('amount_last_paid', 15, 2)->nullable();
            $table->date('last_paid_date')->nullable();
            
            $table->unique(['empID', 'type'], 'unique_index');
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
        Schema::dropIfExists('loan');
    }
}
