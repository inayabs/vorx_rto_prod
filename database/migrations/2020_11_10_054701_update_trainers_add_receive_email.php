<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrainersAddReceiveEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('trainers', 'receive_email')) {
            Schema::table('trainers', function (Blueprint $table) {
                $table->boolean('receive_email')->after('course_location')->unsign()->nullable();
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
        if (Schema::hasColumn('trainers', 'receive_email')) {
            Schema::table('trainers', function (Blueprint $table) {
                $table->dropColumn(['receive_email']);
            });
        }
    }
}
