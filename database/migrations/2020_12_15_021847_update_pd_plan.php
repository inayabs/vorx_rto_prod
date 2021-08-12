<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePdPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pd_plans', 'activity_date')) {
            Schema::table('pd_plans', function (Blueprint $table) {
                $table->date('activity_date')->after('email_date')->nullable();
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
        if (Schema::hasColumn('pd_plans', 'activity_date')) {
            Schema::table('pd_plans', function (Blueprint $table) {
                $table->dropColumn(['activity_date']);
            });
        }
    }
}
