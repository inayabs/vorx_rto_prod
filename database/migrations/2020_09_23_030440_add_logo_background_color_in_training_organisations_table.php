<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoBackgroundColorInTrainingOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('training_organisations', 'logo_background_color')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('logo_background_color', 50)->nullable()->after('logo_img');
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
            $table->dropColumn(['logo_background_color']);
        });
    }
}
