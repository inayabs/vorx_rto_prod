<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferLetterFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('offer_letter_fees', 'discounted_amount')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->decimal('discounted_amount', 10, 2)->after('initial_payment_amount')->nullable();
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
            $table->dropColumn(['discounted_amount']);
        });
    }
}
