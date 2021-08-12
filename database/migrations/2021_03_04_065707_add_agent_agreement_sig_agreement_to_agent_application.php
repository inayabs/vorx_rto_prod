<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentAgreementSigAgreementToAgentApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('agent_application','agent_agreement_sig_agreement')){
            Schema::table('agent_application', function (Blueprint $table) {
                $table->tinyInteger('agent_agreement_sig_agreement')->after('sig_acceptance_agreement')->default(0);
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
        Schema::table('agent_application', function (Blueprint $table) {
            $table->dropColumn('agent_agreement_sig_agreement');
        });
    }
}
