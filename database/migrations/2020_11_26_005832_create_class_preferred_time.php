<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassPreferredTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('preferred_attendances')) {
            Schema::create('preferred_attendances', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('class_id');
                $table->string('unit_code',191);
                $table->date('date_taken');
                $table->time('pref_time_start');
                $table->time('pref_time_end');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('preferred_attendances');
    }
}
