<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVisaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funded_student_visa_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id',191);
            $table->string('nationality',50)->nullable();
            $table->string('passport_number',50)->nullable();
            $table->date('issue_date',50)->nullable();
            $table->date('expiry_date',50)->nullable();
            $table->string('visa_type',50)->nullable();
            $table->string('subclass',50)->nullable();
            $table->date('expiry_date_visa_type',50)->nullable();
            $table->enum('study_rights', ['Yes', 'No'])->nullable();
            $table->enum('applied_for_au_residency', ['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('student_visa_details');
    }
}
