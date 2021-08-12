<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatAgentCommissionCutoffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('agent_commission_cutoffs','agent_id')){
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
               $table->integer('agent_id')->after('serial_no');
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
        if (!Schema::hasColumn('agent_commission_cutoffs', 'agent_id')) {
            Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
                $table->dropColumn('agent_id');
            });
        }
    }
}
