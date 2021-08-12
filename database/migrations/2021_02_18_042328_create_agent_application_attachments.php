<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentApplicationAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_application_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agent_application_id')->nullable();
            $table->string('process_id',10)->nullable();
            $table->string('path_id',255)->nullable();
            $table->string('name',255)->nullable();
            $table->string('hash_name',255)->nullable();
            $table->integer('size')->nullable();
            $table->string('mime_type',255)->nullable();
            $table->string('ext',10)->nullable();
            $table->string('_input',255)->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('linked')->default(0);
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
        Schema::dropIfExists('agent_application_attachments');
    }
}
