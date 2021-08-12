<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAttachmentsAissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_aiss_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id',255)->nullable();
            $table->string('path_id',255)->nullable();
            $table->integer('student_attachment_type_id')->nullable();
            $table->string('name',255)->nullable();
            $table->string('hash_name',255)->nullable();
            $table->integer('size')->nullable();
            $table->string('mime_type',255)->nullable();
            $table->string('ext',255)->nullable();
            $table->string('_input',255)->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('student_attachments_aiss');
    }
}
