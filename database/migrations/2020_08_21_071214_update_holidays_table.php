<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('holidays', 'month')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->string('month',191)->nullable();
            });
        }
        if (!Schema::hasColumn('holidays', 'day')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->string('day',191)->nullable();
            });
        }
        
        // drop date column
        if (Schema::hasColumn('holidays', 'date')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->dropColumn('date');
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
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropColumn(['month', 'day']);
        });
    }
}
