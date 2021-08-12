<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentSchedTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasColumn('payment_schedule_templates', 'invoice_no')) {
            Schema::table('payment_schedule_templates', function (Blueprint $table) {
                $table->dropColumn(['invoice_no'])->default(0);
            });
        }


        Schema::table('payment_schedule_templates', function (Blueprint $table) {
            $table->string('invoice_no')->after('id');
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
            $table->dropColumn(['invoice_no']);
        });
    }
}
