<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionSettingMain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('agent_commission_setting_mains', 'registered_date')){
            Schema::table('agent_commission_setting_mains', function (Blueprint $table) {
                $table->dropColumn('registered_date');
                // $table->date('registered_date')->nullable();
            });
        }
        if (!Schema::hasColumn('agent_commission_setting_mains', 'registered_date')) {
            Schema::table('agent_commission_setting_mains', function (Blueprint $table) {
                // $table->dropColumn('registered_date');
                $table->date('registered_date')->after('gst_type')->nullable();
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
        });
    }
}
