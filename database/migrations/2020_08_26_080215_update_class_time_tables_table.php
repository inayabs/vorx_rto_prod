<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassTimeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('class_time_tables');
        Schema::create('class_time_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('class_id');
            $table->longText('time_table')->nullable();
            $table->string('total_training_hours')->nullable();
            $table->string('total_weeks')->nullable();
            $table->longText('training_days_weekly')->nullable();
            $table->integer('training_hours_daily')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('class_time_tables');
    }
}
