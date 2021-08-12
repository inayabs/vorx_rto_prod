<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedStudentPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_payment_details', 'payment_method_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->integer('payment_method_id')->after('amount')->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'customer_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->string('customer_id')->after('offer_letter_course_detail_id')->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'transaction_code')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->string('transaction_code')->after('customer_id')->nullable();
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
        if (!Schema::hasColumn('funded_student_payment_details', 'payment_method_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->dropColumn('payment_method_id');
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'customer_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->dropColumn('customer_id');
            });
        }
        if (!Schema::hasColumn('funded_student_payment_details', 'transaction_code')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->dropColumn('transaction_code');
            });
        }
    }
}
