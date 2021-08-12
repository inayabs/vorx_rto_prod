<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class CreateEnrolmentMandatoryDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('enrolment_mandatory_documents')){
            Schema::create('enrolment_mandatory_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('document_name', 255);
                $table->string('slug_name', 255);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if(Schema::hasTable('enrolment_mandatory_documents')){
            FacadesDB::table('enrolment_mandatory_documents')->insert([
                'document_name' => 'Passport biodata pages',
                'slug_name' => 'passport',
            ]);
            FacadesDB::table('enrolment_mandatory_documents')->insert([
                'document_name' => 'Past qualification documents, including high school and other certificates',
                'slug_name' => 'qualification',
            ]);
            FacadesDB::table('enrolment_mandatory_documents')->insert([
                'document_name' => 'English language proficiency (IELTS, PTE, TOEFL etc.)',
                'slug_name' => 'language_proficiency',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolment_mandatory_documents');
    }
}
