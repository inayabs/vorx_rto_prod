<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('agent_application')) {
            Schema::create('agent_application', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('agent_name', 255)->nullable();
                $table->string('process_id', 255)->nullable();
                $table->longText('application_form')->nullable();
                $table->longText('ref_form_1')->nullable();
                $table->longText('ref_form_2')->nullable();
                $table->longText('agent_signature')->nullable();
                $table->enum('status', ['process', 'complete', 'verified'])->default('process');
                $table->integer('agent_id')->nullable();
                $table->string('type_signature', 191)->nullable();
                $table->tinyInteger('sig_acceptance_agreement')->default(0);
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('agent_application');
    }
}
