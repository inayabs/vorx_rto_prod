<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewColumnsHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('holidays', 'type')){
            Schema::table('holidays', function (Blueprint $table) {
                $table->string('type',191)->nullable();
            });
        }

        if (!Schema::hasColumn('holidays', 'weekday')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->string('weekday',191)->nullable();
            });
        }

        if(!Schema::hasColumn('holidays', 'week')){
            Schema::table('holidays', function (Blueprint $table) {
                $table->string('week',191)->nullable();
            });
        }

        // update location datatype to text
        if (Schema::hasColumn('holidays', 'location')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->text('location')->change();
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
            $table->dropColumn(['type', 'weekday', 'week']);
        });
    }
}
