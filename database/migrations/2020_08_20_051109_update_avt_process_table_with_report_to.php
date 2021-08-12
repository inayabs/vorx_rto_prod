<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAvtProcessTableWithReportTo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('avt_process', 'report_to')) {
            Schema::table('avt_process', function (Blueprint $table) {
                $table->string('report_to', 5)->nullable();
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
        Schema::table('avt_process', function (Blueprint $table) {
            $table->dropColumn(['report_to']);
        });
    }
}
