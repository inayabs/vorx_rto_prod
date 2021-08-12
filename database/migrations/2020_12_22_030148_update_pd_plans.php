<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePdPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pd_plans', 'activity_type')) {
            Schema::table('pd_plans', function (Blueprint $table) {
                $table->string('activity_type',191)->after('id')->nullable();
                $table->string('activity_description',191)->after('activity_type')->nullable();
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
        Schema::table('pd_plans', function (Blueprint $table) {
            $table->dropColumn(['activity_type']);
            $table->dropColumn(['activity_description']);
        });
    }
}
