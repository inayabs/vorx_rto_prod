<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureAgreementToEnrolmentPackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        if (!Schema::hasColumn('enrolment_pack', 'sig_acceptance_agreement')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->boolean('sig_acceptance_agreement')->default(0)->after('type_signature');
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
            $table->dropColumn(['sig_acceptance_agreement']);
        });
    }
}
