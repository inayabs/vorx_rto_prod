<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendancetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('attendances', 'funded_student_course_id')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->integer('funded_student_course_id')->after('student_id')->nullable();
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
        if (Schema::hasColumn('attendances', 'funded_student_course_id')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->dropColumn('funded_student_course_id');
            });
        }
    }
}
