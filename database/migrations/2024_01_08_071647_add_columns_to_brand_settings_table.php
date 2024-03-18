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
        Schema::table('brand_settings', function (Blueprint $table) {
            $table->string('body_background')->nullable();
            $table->string('website_url')->nullable();
            $table->string('report_system_name')->nullable();
            $table->string('report_top_banner')->nullable();
            $table->string('report_bottom_banner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_settings', function (Blueprint $table) {
            $table->dropColumn('body_background');
            $table->dropColumn('website_url');
            $table->dropColumn('report_system_name');
            $table->dropColumn('report_top_banner');
            $table->dropColumn('report_bottom_banner');
        });
    }
};
