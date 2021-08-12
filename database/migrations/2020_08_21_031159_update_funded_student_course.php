<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedStudentCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('funded_student_course', 'offer_letter_course_detail_id')) {
            Schema::table('funded_student_course', function (Blueprint $table) {
                $table->integer('offer_letter_course_detail_id')->after('id')->nullable();
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
        //
        Schema::table('funded_student_course', function (Blueprint $table) {
            $table->dropColumn(['offer_letter_course_detail_id']);
        });
    }
}
