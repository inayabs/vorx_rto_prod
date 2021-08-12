<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('attendance_details')){
            Schema::create('attendance_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('attendance_id');
                $table->string('unit_code',255);
                $table->date('date_taken');
                $table->time('time_start');
                $table->time('time_end');
                $table->boolean('student_sig');
                $table->boolean('trainer_sig');
                $table->timestamps();
                $table->softDeletes();
            });
        }else{
            //update schema bldr
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_details');
    }
}
