<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedStudentCourseDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_course_details', 'funding_type')) {
            Schema::table('funded_student_course_details', function (Blueprint $table) {
                $table->integer('funding_type')->nullable();
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
        Schema::table('funded_student_course_details', function (Blueprint $table) {
            $table->dropColumn(['funding_type']);
        });
    }
}
