<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCommissionSubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_commission_setting_subs', 'registered_date')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->date('registered_date')->after('gst_status')->nullable();
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
        Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
            $table->dropColumn('registered_date');
        });
    }
}
