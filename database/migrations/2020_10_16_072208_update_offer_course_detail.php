<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferCourseDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('offer_letter_course_details', 'weekly_payment')) {
            Schema::table('offer_letter_course_details', function (Blueprint $table) {
                $table->decimal('weekly_payment', 10, 2)->default(0)->after('tuition_fees')->nullable();
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
        Schema::table('offer_letter_course_details', function (Blueprint $table) {
            $table->dropColumn(['weekly_payment']);
        });
    }
}
