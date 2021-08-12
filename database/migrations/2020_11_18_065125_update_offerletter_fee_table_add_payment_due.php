<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferletterFeeTableAddPaymentDue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('offer_letter_fees', 'payment_due')) {
        Schema::table('offer_letter_fees', function (Blueprint $table) {
            $table->date('payment_due')->after('payment_required')->nullable();
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
        Schema::table('offer_letter_fees', function (Blueprint $table) {
            $table->dropColumn(['payment_due']);
        });
    }
}
