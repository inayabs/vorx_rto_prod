<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentSchedIdOnCommissionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        if(!Schema::hasColumn('commission_details','payment_sched_id')){
            Schema::table('commission_details', function (Blueprint $table) {
                $table->integer('payment_sched_id')->nullable();
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
        Schema::table('commission_details', function (Blueprint $table) {
            //
            $table->dropColumn('payment_sched_id');
        });
    }
}
