<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('classes', 'delivery_mode')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('delivery_mode',9)->after('delivery_loc')->unsign()->nullable();
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
        if (Schema::hasColumn('classes', 'delivery_mode')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn(['delivery_mode']);
            });
        }
    }
}
