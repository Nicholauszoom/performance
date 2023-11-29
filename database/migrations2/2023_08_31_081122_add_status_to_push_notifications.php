<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPushNotifications extends Migration
{
    public function up()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('title');
        });
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
