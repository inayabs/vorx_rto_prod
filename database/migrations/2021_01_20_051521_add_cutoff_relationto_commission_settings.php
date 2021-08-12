<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCutoffRelationtoCommissionSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            //
           
            if (!Schema::hasColumn('agent_commission_setting_subs', 'cut_off_period')) {
                Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                    // $table->string('cut_off_period')->after('commission_type')->nullable();
                    $table->dropColumn(['cut_off_period']);
                });
            }
            if (!Schema::hasColumn('agent_commission_setting_subs', 'commission_cutoff')) {
                Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                    $table->string('commission_cutoff')->after('commission_type')->nullable();
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
        //
        if (Schema::hasColumn('agent_commission_setting_subs', 'commission_cutoff')) {
            Schema::table('agent_commission_setting_subs', function (Blueprint $table) {
                $table->dropColumn(['commission_cutoff']);
            });
        }
    }
}
