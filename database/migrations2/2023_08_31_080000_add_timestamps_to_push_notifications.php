<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToPushNotifications extends Migration
{
    public function up()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            // $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
