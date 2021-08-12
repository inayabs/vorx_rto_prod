<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMandatoryDocsColumnToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('enrolment_pack', 'mandatory_docs')) {
            Schema::table('enrolment_pack', function (Blueprint $table) {
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
        Schema::table('enrolment_pack', function (Blueprint $table) {
            $table->dropColumn(['mandatory_docs']);
        });
    }
}
