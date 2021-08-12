<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionSettingSubAddFundedCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_setting_subs', 'student_course_id')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->integer('student_course_id')->default(0)->after('course_id');
            });
        }
        if (Schema::hasColumn('agent_commission_setting_subs', 'registered_date')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn('registered_date');
            });
        }
        if (Schema::hasColumn('agent_commission_setting_subs', 'registered_date')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->date('registered_date')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('agent_commission_setting_subs', ['student_course_id'])) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn(['student_course_id']);
            });
        }
       
    }
}
