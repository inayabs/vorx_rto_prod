<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableCertificateIssuanceDetailAddSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('certificate_issuance_details', 'sent')) {
            Schema::table('certificate_issuance_details', function (Blueprint $table) {
                $table->tinyInteger('sent')->default(0)->after('soa_number');
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
        Schema::table('certificate_issuance_details', function (Blueprint $table) {
            //
            $table->dropColumn(['sent']);
        });
    }
}
