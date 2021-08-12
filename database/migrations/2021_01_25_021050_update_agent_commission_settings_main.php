<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionSettingsMain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_setting_mains', 'commission_cutoff')) {
            Schema::table('agent_commission_setting_mains', function (Blueprint $table) {
                $table->string('commission_cutoff')->after('commission_type')->nullable();
            });
        }
        if (Schema::hasColumn('agent_commission_setting_subs', 'commission_cutoff')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn('commission_cutoff');
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
        Schema::table('agent_commission_setting_mains', function (Blueprint $table) {
            //
            $table->drop('commission_cutoff');
        });
    }
}
