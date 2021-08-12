<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnrolmentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $columns = [
            'funding_type',
            'outcome_id_national',
            'funding_source_national',
            'commence_prg_identifier',
            'training_contract_id',
            'client_id_apprenticeships',
            'study_reason_id',
            'specific_funding_id',
            'funding_source_state_training_authority',
            'purchasing_contract_id',
            'purchasing_contract_schedule_id',
            'associated_course_id',
            'predominant_delivery_mode',
            'full_time_leaning_option'
        ];
        foreach ($columns as $column) {
            // if (!Schema::hasColumn('offer_letter_course_enrolment_details', $column)) {
            if ($column == 'funding_type') {
                Schema::table('offer_letter_course_enrolment_details', function (Blueprint $table) use ($column) {
                    $table->integer($column)->nullable()->change();
                });
            } else {
                Schema::table('offer_letter_course_enrolment_details', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable()->change();
                });
            }
            // }
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
    }
}
