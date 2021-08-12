<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompletionDetailsAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasColumn('student_completion_details', 'order')) {
            Schema::table('student_completion_details', function (Blueprint $table) {
                $table->dropColumn(['order']);
            });
        }


        Schema::table('student_completion_details', function (Blueprint $table) {
            $table->integer('order')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('student_completion_details', function (Blueprint $table) {
            $table->dropColumn(['order']);
        });
    }
}
