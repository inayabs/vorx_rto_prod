<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassTimeTableTableWithHolidayIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('class_time_tables', 'holiday_ids')) {
            Schema::table('class_time_tables', function (Blueprint $table) {
                $table->text('holidays')->nullable();
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
            $table->dropColumn(['holidays']);
        });
    }
}
