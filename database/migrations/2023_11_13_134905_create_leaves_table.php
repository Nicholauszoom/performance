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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('empid');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->date('application_date')->nullable();
            $table->integer('days')->default(0);
            $table->string('leave_address', 50)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('nature', 50)->default('');
            $table->string('state', 1)->default('1')->comment('0-completed, 1-on progress');
            $table->string('approved_by')->nullable();
            $table->string('recomended_by', 10)->nullable();
            $table->string('position')->nullable();
            $table->string('level1', 10)->nullable();
            $table->string('level2', 10)->nullable();
            $table->string('level3', 10)->nullable();
            $table->integer('attachment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->string('status');
            $table->string('sub_category')->nullable();
            $table->string('reason');
            $table->string('remaining');
            $table->string('deligated')->nullable();
            $table->string('revoke_reason')->nullable();
            $table->string('enddate_revoke')->nullable();
            $table->string('revoke_status')->nullable();
            $table->timestamp('revoke_created_at')->nullable();
            $table->string('revok_escalation_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
        
    }
};
