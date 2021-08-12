<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStripeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('stripe_payments', 'country_id')) {
            Schema::table('stripe_payments', function (Blueprint $table) {
                $table->dropColumn('country_id');
            });
        }
        if (Schema::hasColumn('stripe_payments', 'state')) {
            Schema::table('stripe_payments', function (Blueprint $table) {
                $table->dropColumn('state');
            });
        }
        if (Schema::hasColumn('stripe_payments', 'city')) {
            Schema::table('stripe_payments', function (Blueprint $table) {
                $table->dropColumn('city');
            });
        }

        // Schema::table('stripe_payments', function (Blueprint $table) {
        //     $table->dropColumn('country_id');
        //     $table->dropColumn('state');
        //     $table->dropColumn('city');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        // if (!Schema::hasColumn('stripe_payments', 'country_id')) {
        //     Schema::table('stripe_payments', function (Blueprint $table) {
        //         $table->dropColumn('country_id');
        //     });
        // }
        // if (!Schema::hasColumn('stripe_payments', 'state')) {
        //     Schema::table('stripe_payments', function (Blueprint $table) {
        //         $table->dropColumn('state');
        //     });
        // }
        // if (!Schema::hasColumn('stripe_payments', 'city')) {
        //     Schema::table('stripe_payments', function (Blueprint $table) {
        //         $table->dropColumn('city');
        //     });
        // }
    }
}
