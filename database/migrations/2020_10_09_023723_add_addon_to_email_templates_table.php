<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddonToEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('email_templates', 'email_type')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->string('email_type', 191)->nullable()->after('email_content');
            });
        }

        if (!Schema::hasColumn('email_templates', 'add_on')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->string('add_on', 255)->nullable()->after('email_type');
            });
        }

        if (!Schema::hasColumn('email_templates', 'succeeding_email_type')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->string('succeeding_email_type', 255)->nullable()->after('email_type');
            });
        }

        if (!Schema::hasColumn('email_templates', 'interval')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->integer('interval')->default(0)->after('email_type');
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
        if (Schema::hasColumn('email_templates', 'add_on')) {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->dropColumn(['email_type','add_on', 'succeeding_email_type', 'interval']);
            });
        }
    }
}
