<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrainingOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('training_organisations', 'avetmiss_organisation_id')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('avetmiss_organisation_id',10)->nullable();
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
        Schema::table('training_organisations', function (Blueprint $table) {
            $table->dropColumn(['avetmiss_organisation_id']);
        });
    }
}
