<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmergencyContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('funded_student_contact_details', 'emer_name')) {
            Schema::table('funded_student_contact_details', function (Blueprint $table) {
                $table->string('emer_name',191)->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_contact_details', 'emer_address')) {
            Schema::table('funded_student_contact_details', function (Blueprint $table) {
                $table->string('emer_address',191)->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_contact_details', 'emer_telephone')) {
            Schema::table('funded_student_contact_details', function (Blueprint $table) {
                $table->string('emer_telephone',50)->nullable();
            });
        }
        if (!Schema::hasColumn('funded_student_contact_details', 'emer_relationship')) {
            Schema::table('funded_student_contact_details', function (Blueprint $table) {
                $table->string('emer_relationship',50)->nullable();
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
        Schema::table('funded_student_contact_details', function (Blueprint $table) {
            $table->dropColumn(['emer_name', 'emer_address','emer_telephone','emer_relationship']);
        });
    }
}
