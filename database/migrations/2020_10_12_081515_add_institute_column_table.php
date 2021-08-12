<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstituteColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_details', 'institute')) {
            Schema::table('funded_student_details', function (Blueprint $table) {
                $table->string('institute',191)->after('at_school_flag')->nullable();
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
        Schema::table('funded_student_details', function (Blueprint $table) {
            $table->dropColumn(['institute']);
        });
    }
}
