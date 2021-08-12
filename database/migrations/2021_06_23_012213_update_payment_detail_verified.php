<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentDetailVerified extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasColumn('funded_student_payment_details','verified')){
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                    $table->tinyInteger('verified')->default(0);
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
        Schema::table('funded_student_payment_details', function (Blueprint $table) {
            //
            $table->dropColumn('verified');
        });
    }
}
