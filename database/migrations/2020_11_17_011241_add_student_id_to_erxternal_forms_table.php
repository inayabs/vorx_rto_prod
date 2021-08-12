<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentIdToErxternalFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('external_forms', 'student_id')) {
            Schema::table('external_forms', function (Blueprint $table) {
                $table->string('student_id', 10)->after('id')->nullable();
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
        Schema::table('external_forms', function (Blueprint $table) {
            $table->dropColumn(['student_id']);
        });
    }
}
