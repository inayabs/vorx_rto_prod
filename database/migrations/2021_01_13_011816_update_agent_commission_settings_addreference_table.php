<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionSettingsAddreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_setting_subs', 'agent_commission_setting_main_id')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->integer('agent_commission_setting_main_id')->after('id');
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
        if (Schema::hasColumn('agent_commission_setting_subs', 'agent_commission_setting_main_id')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn(['agent_commission_setting_main_id']);
            });
        }
    }
}
