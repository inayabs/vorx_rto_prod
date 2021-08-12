<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasColumn('payment_schedule_templates', 'payable_amount')) {
            Schema::table('payment_schedule_templates', function (Blueprint $table) {
                $table->dropColumn(['payable_amount']);
            });
        }


        Schema::table('payment_schedule_templates', function (Blueprint $table) {
            $table->decimal('payable_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('payment_schedule_templates', function (Blueprint $table) {
            $table->dropColumn(['payable_amount']);
        });
    }
}
