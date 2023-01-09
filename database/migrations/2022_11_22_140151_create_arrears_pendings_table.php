<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrearsPendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrears_pendings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->bigInteger('arrear_id');
            $table->decimal('amount', 15, 2);
            $table->integer('status')->default(0)->comment("1-Confirmed, 0-Not Confirmed");
            $table->string('init_by', 10);
            $table->date('date_confirmed');
            $table->string('confirmed_by', 10);
            $table->string('date_recommended', 110);
            $table->string('recommended_by', 110);
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
        Schema::dropIfExists('arrears_pendings');
    }
}
