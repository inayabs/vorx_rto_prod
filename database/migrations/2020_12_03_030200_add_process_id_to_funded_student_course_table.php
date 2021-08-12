<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessIdToFundedStudentCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_course', 'process_id')) {
            Schema::table('funded_student_course', function (Blueprint $table) {
                $table->string('process_id', 10)->after('student_id')->nullable();
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
            $table->dropColumn(['process_id']);
        });
    }
}
