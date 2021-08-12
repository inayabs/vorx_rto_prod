<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrientationDateInOfferLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('offer_letters', 'orientation_date')) {
            Schema::table('offer_letters', function (Blueprint $table) {
                $table->date('orientation_date')->nullable()->after('status_id');
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
        if (Schema::hasColumn('offer_letters', 'orientation_date')) {
            Schema::table('offer_letters', function (Blueprint $table) {
                $table->dropColumn(['orientation_date']);
            });
        }
    }
}
