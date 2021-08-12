<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExternalforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('external_forms', 'name')) {
            Schema::table('external_forms', function (Blueprint $table) {
                $table->string('name')->nullable()->after('id');
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
        //
        if(Schema::hasColumn('external_forms', 'name')) {
            Schema::table('external_forms', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
}
