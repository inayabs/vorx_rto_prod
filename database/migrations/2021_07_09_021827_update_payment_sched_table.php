<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentSchedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payment_schedule_templates', 'commission')) {
            Schema::table('payment_schedule_templates', function (Blueprint $table) {
                $table->decimal('commission',10,2)->default(0);
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
        
        
            Schema::table('payment_schedule_templates', function (Blueprint $table) {
                $table->dropColumn('commission');
            });
    }
}
