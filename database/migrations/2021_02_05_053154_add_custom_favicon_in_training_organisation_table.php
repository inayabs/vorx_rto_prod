<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFaviconInTrainingOrganisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        if (!Schema::hasColumn('training_organisations', 'custom_favicon')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('custom_favicon', 191)->nullable()->after('custom_invoice');
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
        if (Schema::hasColumn('training_organisations', 'custom_favicon')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->dropColumn(['custom_favicon']);
            });
        }
    }
}
