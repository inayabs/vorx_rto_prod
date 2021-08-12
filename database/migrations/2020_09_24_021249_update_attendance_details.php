<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendanceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('attendance_details', 'time_start')) {
            Schema::table('attendance_details', function (Blueprint $table) {
                $table->time('time_start')->nullable();
            });
        }
        if (!Schema::hasColumn('attendance_details', 'time_end')) {
            Schema::table('attendance_details', function (Blueprint $table) {
                $table->time('time_end')->nullable();
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
    }
}
