<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnrolmentTypeInEnrolmentPackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('enrolment_pack', 'enrolment_type')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->string('enrolment_type', 50)->nullable();
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
        if (Schema::hasColumn('enrolment_pack', 'enrolment_type')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->dropColumn(['enrolment_type']);
            });
        }
    }
}
