<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseWorkbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student_course_workbook_attachments')) {
            Schema::create('student_course_workbook_attachments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('funded_student_course_id');
                $table->string('student_id', 20)->nullable();
                $table->string('course_code', 20)->nullable();
                $table->string('name', 255)->nullable();
                $table->string('path', 255)->nullable();
                $table->string('hash_name', 255)->nullable();
                $table->integer('size')->nullable();
                $table->string('mime_type', 255)->nullable();
                $table->string('ext', 255)->nullable();
                $table->string('_input', 255)->nullable();
                $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('student_course_workbook_attachments');
    }
}
