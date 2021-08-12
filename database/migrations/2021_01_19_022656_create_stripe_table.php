<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('stripe_payments')) {
            Schema::create('stripe_payments', function (Blueprint $table) {
                $table->bigIncrements('id');
                    $table->string('firstname',255)->nullable();
                    $table->string('lastname',255)->nullable();
                    $table->string('address',255)->nullable();
                    $table->string('country_id',255)->nullable();
                    $table->string('state',255)->nullable();
                    $table->string('city',255)->nullable();
                    $table->string('postcode',255)->nullable();
                    $table->string('receipt_email',255)->nullable();
                    $table->bigInteger('contact_no')->nullable();
                    $table->string('currency')->nullable();
                    $table->decimal('amount',10,2);
                    $table->string('name_on_card',255)->nullable();
                    $table->timestamps();
                    $table->softDeletes();
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
        Schema::dropIfExists('stripe_payments');
    }
}
