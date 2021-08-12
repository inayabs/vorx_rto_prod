<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendanceDetailsAbsent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('attendance_details', 'status')) {
            Schema::table('attendance_details', function (Blueprint $table) {
                $table->enum('status',['Present','Absent','N/A'])->after('time_end')->unsign()->nullable();
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
        if (Schema::hasColumn('attendance_details', 'status')) {
            Schema::table('attendance_details', function (Blueprint $table) {
                $table->dropColumn(['status']);
            });
        }
    }
}
