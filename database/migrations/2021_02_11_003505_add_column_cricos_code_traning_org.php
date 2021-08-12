<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCricosCodeTraningOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('training_organisations','cricos_code')){
            Schema::table('training_organisations', function (Blueprint $table) {
                $table->string('cricos_code')->nullable();
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
        Schema::table('training_organisations', function (Blueprint $table) {
            //
            $table->dropColumn('cricos_code');
        });
    }
}
