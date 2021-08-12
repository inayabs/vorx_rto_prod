<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableStudentCompletionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('student_completion_details', 'training_hours')) {
            Schema::table('student_completion_details', function (Blueprint $table) {
                $table->integer('training_hours')->after('actual_end')->nullable()->unsigned();
            });
        }
        if (!Schema::hasColumn('student_completion_details', 'trainer_id')) {
            Schema::table('student_completion_details', function (Blueprint $table) {
                $table->integer('trainer_id')->after('actual_end')->nullable()->unsigned();
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
        Schema::table('student_completion_details', function (Blueprint $table) {
            $table->dropColumn(['trainer_id', 'training_hours']);
        });
    }
}
