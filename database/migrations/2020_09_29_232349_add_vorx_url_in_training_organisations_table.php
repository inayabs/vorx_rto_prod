<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVorxUrlInTrainingOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('training_organisations', 'vorx_url')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('vorx_url', 255)->nullable()->after('site_url');
            });
        }
        if (!Schema::hasColumn('training_organisations', 'student_url')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('student_url', 255)->nullable()->after('site_url');
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
        if (Schema::hasColumn('training_organisations', 'vorx_url')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->dropColumn(['vorx_url']);
            });
        }
        if (Schema::hasColumn('training_organisations', 'student_url')) {
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->dropColumn(['student_url']);
            });
        }
    }
}
