<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedStudentDetailsWithYearCompleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_details', 'year_completed')) {
            Schema::table('funded_student_details', function (Blueprint $table) {
                $table->string('year_completed', 10)->nullable();
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
            $table->dropColumn(['year_completed']);
        });
    }
}
