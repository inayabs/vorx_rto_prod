<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['class_start_time','class_end_time']);
        });
        
        Schema::table('attendance_details', function (Blueprint $table) {
            $table->dropColumn(['time_start','time_end']);
            $table->integer('preferred_hours')->after('date_taken')->nullable();
            $table->integer('actual_hours')->after('preferred_hours')->nullable();
        });

        Schema::dropIfExists('preferred_attendances');
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
