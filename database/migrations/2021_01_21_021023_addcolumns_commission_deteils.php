<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnsCommissionDeteils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('commission_details', 'agent_commission_settings_sub_id')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->integer('agent_commission_settings_sub_id')->after('serial_no');
            });
        }

        if (!Schema::hasColumn('commission_details', 'comm_release_status')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->decimal('comm_release_status',11,2)->after('pre_deducted_comission');
            });
        }

        if (!Schema::hasColumn('commission_details', 'computed_commission')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->decimal('computed_commission',11,2)->after('pre_deducted_comission');
            });
        }

        if (!Schema::hasColumn('commission_details', 'amount_received')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->decimal('amount_received',11,2)->after('actual_amount');
            });
        }
        if (!Schema::hasColumn('commission_details', 'accumulated')) {
            Schema::table('commission_details', function (Blueprint $table) {
                $table->decimal('accumulated',11,2)->after('actual_amount');
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
            $table->dropColumn(['agent_commission_settings_sub_id', 'comm_release_status', 'computed_commission', 'amount_received', 'accumulated']);
        });
    }
}
