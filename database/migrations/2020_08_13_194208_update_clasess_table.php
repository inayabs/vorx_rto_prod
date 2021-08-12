<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClasessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('classes', 'location')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('location', 10)->nullable();
            });
        }
        if (!Schema::hasColumn('classes', 'venue')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('venue', 191)->nullable();
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
        //
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['location', 'venu']);
        });
    }
}
