<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableCommissionSubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_setting_subs', 'cut_off_period')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->string('cut_off_period')->after('commission_type')->nullable();
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
        if (Schema::hasColumn('agent_commission_setting_subs', 'cut_off_period')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn(['cut_off_period']);
            });
        }
    }
}
