<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('funded_student_payment_details', 'collection_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->string('collection_id')->after('verified')->nullable();
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
        if (!Schema::hasColumn('funded_student_payment_details', 'collection_id')) {
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->dropColumn('collection_id');
            });
        }
    }
}
