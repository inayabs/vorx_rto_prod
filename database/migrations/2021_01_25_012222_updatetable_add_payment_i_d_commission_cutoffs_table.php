<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatetableAddPaymentIDCommissionCutoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('commission_details', 'payment_id')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->integer('payment_id')->after('agent_commission_settings_sub_id');
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
            $table->dropColumn(['payment_id']);
        });
    }
}
