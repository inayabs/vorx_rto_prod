<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePaymentTemplateAddAdjustedDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('payment_schedule_templates','adjusted_date')){
        Schema::table('payment_schedule_templates', function (Blueprint $table) {
                //
                $table->date('adjusted_date')->nullable()->after('due_date');
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
      
        if(Schema::hasColumn('payment_schedule_templates','adjusted_date')){
            Schema::table('payment_schedule_templates', function (Blueprint $table) {
                $table->dropColumn('adjusted_date');
            });
        }
    }
}
