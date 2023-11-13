<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToPushNotifications extends Migration
{
    public function up()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->string('token')->after('status')->nullable();
        });
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}
