<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRemarksColumnPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('funded_student_payment_details','remarks')){
            Schema::table('funded_student_payment_details', function (Blueprint $table) {
                $table->string('remarks')->after('verified')->nullable();
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
            $table->dropColumn('remarks');
        });
    }
}
