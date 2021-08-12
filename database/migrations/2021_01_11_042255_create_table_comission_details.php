<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableComissionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_details', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('serial_no');
            $table->date('cutoff');
            $table->date('payment_date');
            $table->decimal('commission_payable',10,2);
            $table->decimal('pre_deducted_comission',10,2);
            $table->decimal('actual_amount',10,2);
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
               Schema::dropIfExists('commission_details');
    }
}
