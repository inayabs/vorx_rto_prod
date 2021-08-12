<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnrolmentPackAddStudentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('enrolment_pack', 'student_type')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->integer('student_type')->unsigned()->after('student_id')->nullable();
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
        Schema::table('funded_student_details', function (Blueprint $table) {
            $table->dropColumn(['institute']);
        });
    }
}
