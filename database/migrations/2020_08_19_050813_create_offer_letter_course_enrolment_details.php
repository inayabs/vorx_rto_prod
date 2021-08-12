<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferLetterCourseEnrolmentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_letter_course_enrolment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('offer_letter_course_detail_id');
            $table->string('outcome_id_national', 50);
            $table->integer('funding_type');;
            $table->string('funding_source_national', 50);
            $table->string('commence_prg_identifier', 50);
            $table->string('training_contract_id', 50);
            $table->string('client_id_apprenticeships', 50);
            $table->string('study_reason_id', 50);
            $table->string('specific_funding_id', 50);
            $table->string('funding_source_state_training_authority', 50);
            $table->string('purchasing_contract_id', 50);
            $table->string('purchasing_contract_schedule_id', 50);
            $table->string('associated_course_id', 50);
            $table->string('predominant_delivery_mode', 50);
            $table->string('full_time_leaning_option', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_letter_course_enrolment_details');
    }
}
