<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatetableAgentCommissioncutoffsAddOverpayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_cutoffs', 'total_over_payment')) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->decimal('total_over_payment',10,2)->default(0)->after('due_comission');
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
        if (Schema::hasColumns('agent_commission_cutoffs', ['total_over_payment'])) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->dropColumn(['total_over_payment']);
            });
        }
    }
}
