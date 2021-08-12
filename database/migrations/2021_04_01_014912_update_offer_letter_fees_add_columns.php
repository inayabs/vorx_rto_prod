<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferLetterFeesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('offer_letter_fees',['installment_start_date','installment_desired_amount','installment_interval'])){
            Schema::table('offer_letter_fees', function (Blueprint $table) {
                $table->date('installment_start_date')->nullable();
                $table->decimal('installment_desired_amount',10,2);
                $table->integer('installment_interval');
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
        Schema::table('offer_letter_fees', function (Blueprint $table) {
            //
            $table->dropColumn(['installment_start_date','installment_desired_amount','installment_interval']);
        });
    }
}
