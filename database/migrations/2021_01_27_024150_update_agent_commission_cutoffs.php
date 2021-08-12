<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgentCommissionCutoffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
            //
            $table->decimal('total_actual_amount_received')->nullable()->change();
            // $table->decimal('total_commission_paid')->nullable()->change();
            $table->decimal('due_comission')->nullable()->change();
            $table->decimal('total_payable_gst')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_commission_cutoffs', function (Blueprint $table) {
            //
        });
    }
}
