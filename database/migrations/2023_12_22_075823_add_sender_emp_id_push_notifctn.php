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
            $table->renameColumn('emp_id', 'sender_emp_id'); // Rename emp_id to sender_emp_id
            // $table->unsignedBigInteger('receiver_emp_id')->after('sender_emp_id'); // Add receiver_emp_id column
        });
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->renameColumn('sender_emp_id', 'emp_id'); // Rollback: Rename sender_emp_id back to emp_id
            // $table->dropColumn('receiver_emp_id'); // Rollback: Drop receiver_emp_id column
        });
    }
};
