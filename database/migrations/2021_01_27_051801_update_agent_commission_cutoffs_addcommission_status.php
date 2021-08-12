<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionCutoffsAddcommissionStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('agent_commission_cutoffs','commission_release_status')){
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->tinyInteger('commission_release_status')->default(0)->after('due_comission');
            });
        }
        if (!Schema::hasColumn('agent_commission_cutoffs', 'total_commission_paid')) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->decimal('total_commission_paid',10,2)->default(0)->after('commission_release_status');
            });
        }
        if (!Schema::hasColumn('agent_commission_cutoffs', 'total_pre_deducted_comission')) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->decimal('total_pre_deducted_comission', 10, 2)->default(0)->before('due_comission');
            });
        }
        if (!Schema::hasColumn('agent_commission_cutoffs', 'total_computed_commission')) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->decimal('total_computed_commission', 10, 2)->default(0)->after('total_actual_amount_received');
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
        if (Schema::hasColumns('agent_commission_cutoffs', ['commission_release_status', 'total_commission_paid', 'total_pre_deducted_comission', 'total_computed_commission'])) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->dropColumn(['commission_release_status', 'total_commission_paid', 'total_pre_deducted_comission', 'total_computed_commission']);
            });
        }
    }
}
