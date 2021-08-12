<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrainerCourseLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('trainers', 'course_location')) {
            Schema::table('trainers', function (Blueprint $table) {
                $table->text('course_location')->nullable()->change();
            });
        }else{
            Schema::table('trainers', function (Blueprint $table) {
                $table->text('course_location')->nullable();
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
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn(['course_location']);
        });
    }
}
