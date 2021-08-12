<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExternalFormsTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('external_forms', 'status')) {
            Schema::table('external_forms', function (Blueprint $table) {
                $table->enum('status',['complete','process','verified'])->nullable()->after('form_txt');
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
        if(Schema::hasColumn('external_forms', 'status')) {
            Schema::table('external_forms', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
