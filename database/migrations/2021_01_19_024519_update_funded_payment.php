<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_payment_details', 'stripe_payments_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->integer('stripe_payments_id')->after('offer_letter_course_detail_id')->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'refunded')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->integer('refunded')->after('sent_receipt')->default('0')->nullable();
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
        if (!Schema::hasColumn('funded_student_payment_details', 'stripe_payments_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->drop('stripe_payments_id');
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'refunded')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->drop('refunded');
            });
        }
    }
}
