<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCoursePackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('course_package_details', function (Blueprint $table) {
            $table->string('course_code', 10)->nullable();
            $table->integer('wk_duration')->nullable();
            $table->decimal('tuition_fee', 11, 2)->nullable();
            $table->decimal('material_fee', 11,2)->nullable();
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
        Schema::table('course_units', function (Blueprint $table) {
            $table->dropColumn(['course_code', 'wk_duration', 'tuition_fee', 'material_fee']);
        });
    }
}
