<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentEnglishTestTestDateNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('student_english_tests', 'test_date')) {
            Schema::table('student_english_tests', function (Blueprint $table) {
                $table->time('test_date')->nullable();
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
        Schema::table('student_english_tests', function (Blueprint $table) {
            $table->dropColumn(['test_date']);
        });
    }
}
