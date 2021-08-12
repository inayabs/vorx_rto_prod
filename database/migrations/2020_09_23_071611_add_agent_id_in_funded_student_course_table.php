<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdInFundedStudentCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_course', 'agent_id')) {
            Schema::table('funded_student_course', function (Blueprint $table) {
                $table->integer('agent_id')->nullable()->after('location');
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
        Schema::table('funded_student_course', function (Blueprint $table) {
            $table->dropColumn(['logo_background_color']);
        });
    }
}
