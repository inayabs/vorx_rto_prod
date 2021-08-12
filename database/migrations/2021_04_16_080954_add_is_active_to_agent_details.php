<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToAgentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_details', 'is_active')) {
            Schema::table('agent_details', function (Blueprint $table) {
                $table->tinyInteger('is_active')->after('agent_code')->nullable();
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
        Schema::table('agent_details', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
