<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentIdPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumns('funded_student_payment_details',['agent_id'])){
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                //
                $table->Integer('agent_id')->after('student_id')->nullable();    
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
        Schema::table('funded_student_payment_details', function (Blueprint $table) {
            //
            $table->dropColumn(['agent_id']);
        });
    }
}
