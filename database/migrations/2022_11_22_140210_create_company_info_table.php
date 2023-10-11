<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_info', function (Blueprint $table) {
            $table->id();
            $table->string('tin', 11)->nullable();
            $table->string('cname', 100)->nullable();
            $table->string('postal_address', 50)->nullable();
            $table->string('postal_city', 50)->nullable();
            $table->string('phone_no1', 15)->nullable();
            $table->string('phone_no2', 15)->nullable();
            $table->string('phone_no3', 15)->nullable();
            $table->string('fax_no', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('plot_no', 20)->nullable();
            $table->string('block_no', 20)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('branch', 50)->nullable();
            $table->string('wcf_reg_no', 50)->nullable();
            $table->string('heslb_code_no', 20)->nullable();
            $table->string('business_nature', 100)->nullable();
            $table->string('company_type', 50)->nullable();
            $table->string('logo', 50)->nullable();
            $table->string('nssf_control_number', 200);
            $table->string('nssf_reg', 200);
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
        Schema::dropIfExists('company_info');
    }
}
