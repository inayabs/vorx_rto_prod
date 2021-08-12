<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentReceiptToFundedStudentPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_payment_details', 'sent_receipt')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->integer('sent_receipt')->after('user_id')->default('0');
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
        Schema::table('funded_student_payment_details', function (Blueprint $table) {
            $table->dropColumn(['sent_receipt']);
        });
    }
}
