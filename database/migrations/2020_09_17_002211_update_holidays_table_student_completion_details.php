<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHolidaysTableStudentCompletionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('student_completion_details', 'holidays')) {
            Schema::table('student_completion_details', function (Blueprint $table) {
                $table->longText('holidays')->after('training_hours')->nullable();
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
        Schema::table('student_completion_details', function (Blueprint $table) {
            $table->dropColumn(['holidays']);
        });
    }
}
