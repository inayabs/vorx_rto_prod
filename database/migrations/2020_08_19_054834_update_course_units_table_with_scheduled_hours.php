<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCourseUnitsTableWithScheduledHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('course_units', 'scheduled_hours')) {
            Schema::table('course_units', function (Blueprint $table) {
                $table->integer('scheduled_hours')->nullable();
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
        Schema::table('course_units', function (Blueprint $table) {
            $table->dropColumn(['scheduled_hours']);
        });

    }
}
