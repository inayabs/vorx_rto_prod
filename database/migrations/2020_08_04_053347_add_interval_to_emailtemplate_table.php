<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntervalToEmailtemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('email_templates', 'interval')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->integer('interval')->default('0')->nullable();
            });
        }
        if (!Schema::hasColumn('email_templates', 'succeeding_email_type')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->string('succeeding_email_type')->nullable();
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
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn(['interval', 'succeeding_email_type']);
        });
    }
}
