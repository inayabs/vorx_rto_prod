<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedStudentPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_payment_details', 'payment_schedule_template_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->integer('payment_schedule_template_id')->after('offer_letter_course_detail_id')->nullable();
                $table->boolean('verified')->after('refunded')->default(0);
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
            //
            $table->dropColumn('payment_schedule_template_id');
            $table->dropColumn('verified');
        });
    }
}
