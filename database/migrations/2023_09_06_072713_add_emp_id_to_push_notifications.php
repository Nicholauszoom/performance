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
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('emp_id')->nullable(); // Make the column nullable
            // $table->foreign('emp_id')->references('emp_id')->on('employees')->nullable(); // Make the foreign key nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropForeign(['emp_id']);
            $table->dropColumn('emp_id');
        });
    }
};
