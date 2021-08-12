<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('attendances')){
            Schema::create('attendances', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('class_id');
                $table->string('student_id',255);
                $table->string('course_code',255);
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
        Schema::dropIfExists('atendance');
    }
}
