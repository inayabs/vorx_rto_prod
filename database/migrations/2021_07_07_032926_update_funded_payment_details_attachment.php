<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFundedPaymentDetailsAttachment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_detail_attachment', function (Blueprint $table) {
            //
            $table->renameColumn('funded_student_payment_detail_id', 'collection_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_detail_attachment', function (Blueprint $table) {
            //
            $table->renameColumn('collection_id','funded_student_payment_detail_id');
        });
    }
}
