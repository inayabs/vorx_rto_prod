<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressDetailsToDeliveryLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('training_delivery_locations', 'addr_flat_unit_detail')) {
            Schema::table('training_delivery_locations', function (Blueprint $table) {
                $table->string('addr_flat_unit_detail', 50)->after('user_id')->nullable();
            });
        }
        if (!Schema::hasColumn('training_delivery_locations', 'addr_building_property_name')) {
            Schema::table('training_delivery_locations', function (Blueprint $table) {
                $table->string('addr_building_property_name', 50)->after('user_id')->nullable();
            });
        }
        if (!Schema::hasColumn('training_delivery_locations', 'addr_street_name')) {
            Schema::table('training_delivery_locations', function (Blueprint $table) {
                $table->string('addr_street_name', 50)->after('user_id')->nullable();
            });
        }
        if (!Schema::hasColumn('training_delivery_locations', 'addr_street_num')) {
            Schema::table('training_delivery_locations', function (Blueprint $table) {
                $table->string('addr_street_num', 15)->after('user_id')->nullable();
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
        Schema::table('training_delivery_locations', function (Blueprint $table) {
            $table->dropColumn(['addr_flat_unit_detail', 'addr_building_property_name', 'addr_street_name', 'addr_street_num']);
        });
    }
}
