<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSetupInTrainingOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasColumn('training_organisations','is_setup')){
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->tinyInteger('is_setup')->after('cricos_code')->default(0);
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
        if(Schema::hasColumn('training_organisations','is_setup')){
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->dropColumn('is_setup');
            });
        }
    }
}
