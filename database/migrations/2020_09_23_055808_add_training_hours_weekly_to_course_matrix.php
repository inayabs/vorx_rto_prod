<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainingHoursWeeklyToCourseMatrix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('course_matrices', 'training_hours_weekly')) {
            Schema::table('course_matrices', function (Blueprint $table) {
                $table->integer('training_hours_weekly')->after('wk_duration')->nullable();
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
        Schema::table('course_matrices', function (Blueprint $table) {
            $table->dropColumn(['training_hours_weekly']);
        });
    }
}
