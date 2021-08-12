<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB as FacadesDB;

class CreateAgentMandatoryDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('agent_application_mandatory_documents', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->timestamps();
        // });
        if(!Schema::hasTable('agent_application_mandatory_documents')){
            Schema::create('agent_application_mandatory_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('document_name', 255);
                $table->string('slug_name', 255);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if(Schema::hasTable('agent_application_mandatory_documents')){
            FacadesDB::table('agent_application_mandatory_documents')->insert([
                'document_name' => 'Company profile/company registration certificate ',
                'slug_name' => 'company_profile',
            ]);
            FacadesDB::table('agent_application_mandatory_documents')->insert([
                'document_name' => 'Two referees from two Australian colleges you have been referring the students to.',
                'slug_name' => 'two_referees',
            ]);
            FacadesDB::table('agent_application_mandatory_documents')->insert([
                'document_name' => 'Memberships/Registrations (If Any)',
                'slug_name' => 'membership',
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
        Schema::dropIfExists('agent_application_mandatory_documents');
    }
}
