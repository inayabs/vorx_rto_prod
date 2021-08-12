<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainingHoursWeeklyInClassTimeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('class_time_tables', 'training_hours_weekly')){
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->integer('training_hours_weekly')->nullable();
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
        Schema::table('class_time_tables', function (Blueprint $table) {
            $table->dropColumn(['training_hours_weekly']);
        });
    }
}
