<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendanceDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('attendance_details');
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('attendance_id');
            $table->string('unit_code');
            $table->date('date_taken');
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->tinyInteger('student_sig')->nullable();
            $table->tinyInteger('trainer_sig')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
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
