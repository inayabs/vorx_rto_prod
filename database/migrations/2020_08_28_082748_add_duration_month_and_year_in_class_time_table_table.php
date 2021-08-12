<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationMonthAndYearInClassTimeTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('class_time_tables', 'duration_month')){
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->string('duration_month',50)->nullable();
            });
        }
        if(!Schema::hasColumn('class_time_tables', 'duration_year')){
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->string('duration_year',50)->nullable();
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
            $table->dropColumn(['duration_month', 'duration_year']);
        });
    }
}
