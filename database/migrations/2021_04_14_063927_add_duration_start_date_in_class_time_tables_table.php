<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationStartDateInClassTimeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('class_time_tables','duration_start_date')){
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->date('duration_start_date')->after('class_id')->nullable();
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
        if(Schema::hasColumn('class_time_tables','duration_start_date')){
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->dropColumn('duration_start_date');
            });
        }
    }
}
