<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportCourseStatusIdInFundedStudentCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funded_student_course', function (Blueprint $table) {
            //
        });

        if(!Schema::hasColumn('funded_student_course','report_course_status_id')){
            Schema::table('funded_student_course', function (Blueprint $table) {
                $table->integer('report_course_status_id')->default(2)->after('uc_description');
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
        if (Schema::hasColumn('funded_student_course', 'report_course_status_id')) {
            Schema::table('funded_student_course', function (Blueprint $table) {
                $table->dropColumn(['report_course_status_id']);
            });
        }
    }
}
