<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_branch', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('bank');
            $table->string('street', 30);
            $table->string('region', 20);
            $table->string('country', 20);
            $table->string('branch_code', 10);
            $table->string('swiftcode', 20);
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
        Schema::dropIfExists('bank_branch');
    }
}
