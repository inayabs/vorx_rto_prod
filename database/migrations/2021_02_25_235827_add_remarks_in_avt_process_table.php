<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksInAvtProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('avt_process', 'remarks')) {
            Schema::table('avt_process', function (Blueprint $table) {
                $table->text('remarks')->nullable();
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
        if (Schema::hasColumn('avt_process', 'remarks')) {
            Schema::table('avt_process', function (Blueprint $table) {
                $table->dropColumn(['remarks']);
            });
        }
    }
}
