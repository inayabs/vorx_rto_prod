<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableEnrolmentpackAddOfferSigAgreement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         if (!Schema::hasColumn('enrolment_pack', 'offer_sig_agreement')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
                $table->boolean('offer_sig_agreement')->default(0);
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
    }
}
