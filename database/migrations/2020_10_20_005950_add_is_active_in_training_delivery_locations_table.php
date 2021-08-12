<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveInTrainingDeliveryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('training_delivery_locations', 'is_active')) {
            Schema::table('training_delivery_locations', function (Blueprint $table) {
                $table->tinyInteger('is_active')->after('addr_flat_unit_detail')->default(1);
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
            $table->dropColumn(['is_active']);
        });
    }
}
