<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnrolmentPackAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('enrolment_pack_attachments', 'linked')) {
            Schema::table('enrolment_pack_attachments', function (Blueprint $table) {
                $table->boolean('linked')->unsigned()->default(0);
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
        Schema::table('enrolment_pack_attachments', function (Blueprint $table) {
            $table->dropColumn(['linked']);
        });
    }
}
