<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInitialDetailsInOfferLetterFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('offer_letter_fees', 'initial_application_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->decimal('initial_application_fee',11,2)->after('initial_payment_amount')->nullable();
            });
        }
        if (!Schema::hasColumn('offer_letter_fees', 'initial_material_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->decimal('initial_material_fee',11,2)->after('initial_payment_amount')->nullable();
            });
        }
        if (!Schema::hasColumn('offer_letter_fees', 'initial_tuition_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->decimal('initial_tuition_fee',11,2)->after('initial_payment_amount')->nullable();
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
        if (Schema::hasColumn('offer_letter_fees', 'initial_tuition_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->dropColumn(['initial_tuition_fee']);
            });
        }
        if (Schema::hasColumn('offer_letter_fees', 'initial_material_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->dropColumn(['initial_material_fee']);
            });
        }
        if (Schema::hasColumn('offer_letter_fees', 'initial_application_fee')) {
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->dropColumn(['initial_application_fee']);
            });
        }
    }
}
