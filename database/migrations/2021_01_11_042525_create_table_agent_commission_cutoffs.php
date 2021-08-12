<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAgentCommissionCutoffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commission_cutoffs', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('serial_no');
            $table->date('cutoff');
            $table->decimal('total_actual_amount_received',10,2);
            $table->decimal('total_commission_paid',10,2);
            $table->decimal('due_comission',10,2);
            $table->decimal('total_payable_gst',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_commission_cutoffs');
    }
}
