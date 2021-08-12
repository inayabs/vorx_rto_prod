<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcknowledgementAndInductionToEnrolmentPack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('enrolment_pack', 'acknowledgement')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->longtext('acknowledgement')->after('ptr')->nullable();
            });
        }
        if (!Schema::hasColumn('enrolment_pack', 'induction')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->longtext('induction')->after('ptr')->nullable();
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
        Schema::table('enrolment_pack', function (Blueprint $table) {
            $table->dropColumn(['acknowledgement', 'induction']);
        });
    }
}
