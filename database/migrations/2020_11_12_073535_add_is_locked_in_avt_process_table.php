<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedInAvtProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('avt_process', 'is_locked')) {
            Schema::table('avt_process', function (Blueprint $table) {
                $table->boolean('is_locked')->default(0)->after('status_id');
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
        if (!Schema::hasColumn('avt_process', 'is_locked')) {
            Schema::table('avt_process', function (Blueprint $table) {
                $table->dropColumn(['is_locked']);
            });
        }
    }
}
