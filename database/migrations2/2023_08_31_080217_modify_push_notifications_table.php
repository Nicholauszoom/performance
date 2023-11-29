<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPushNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->id()->first()->change(); // This sets the id as primary and auto-increment
        });
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            // If you need to rollback the changes, you might need to drop and recreate the table
        });
    }
}
