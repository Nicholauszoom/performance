<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_emails', function (Blueprint $table) {
            $table->id();
            $table->string('host', 100);
            $table->string('username', 50);
            $table->string('password', 50);
            $table->string('name', 100);
            $table->string('email', 50);
            $table->string('secure', 20)->comment("SMTPSecure");
            $table->integer('port');
            $table->integer('use_as')->comment("1-Send Payslip");
            $table->integer('state')->default(1)->comment("1-active, 0-Not active");
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
        Schema::dropIfExists('company_emails');
    }
}
