<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaveIdAndAppliedByToSickLeaveForfeitDays extends Migration
{
    public function up()
    {
        Schema::table('sick_leave_forfeit_days', function (Blueprint $table) {
            $table->unsignedBigInteger('leaveId')->nullable();
            $table->unsignedBigInteger('appliedBy')->nullable();

       
        });
    }

    public function down()
    {
        Schema::table('sick_leave_forfeit_days', function (Blueprint $table) {
            $table->dropColumn('leaveId');
            $table->dropColumn('appliedBy');
        });
    }
}
