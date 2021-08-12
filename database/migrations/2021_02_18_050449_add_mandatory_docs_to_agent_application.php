<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMandatoryDocsToAgentApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('agent_application', 'mandatory_docs')) {
            Schema::table('agent_application', function (Blueprint $table) {
                $table->longtext('mandatory_docs')->after('status')->nullable();
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
        Schema::table('agent_application', function (Blueprint $table) {
            $table->dropColumn(['mandatory_docs']);
        });
    }
}
