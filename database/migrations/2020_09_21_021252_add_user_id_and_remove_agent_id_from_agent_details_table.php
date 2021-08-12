<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdAndRemoveAgentIdFromAgentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_details', 'user_id')) {
            Schema::table('agent_details', function (Blueprint $table) {
                $table->integer('user_id')->after('id');
            });
        }
        if (Schema::hasColumn('agent_details', 'agent_id')) {
            Schema::table('agent_details', function (Blueprint $table) {
                $table->dropColumn(['agent_id']);
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
            $table->dropColumn(['user_id']);
        });
    }
}
