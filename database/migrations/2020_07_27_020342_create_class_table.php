<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('classes')){
            Schema::create('classes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('desc')->nullable();
                $table->string('trainer_id')->nullable();
                $table->integer('delivery_loc')->nullable();
                $table->string('course_code',255)->nullable();
                $table->string('venue',255)->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->time('class_start_time')->nullable();
                $table->time('class_end_time')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }else{
            //Update
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class');
    }
}
