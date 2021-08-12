<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('student_course_id');
            $table->integer('payment_schedule_template_id');
            $table->string('transaction_code');
            $table->string('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('amount',10,2)->default(0);
            $table->string('pre_deduc_comm');
            $table->tinyInteger('verified')->default(0);
            $table->string('agent_id');
            $table->string('remakrs')->nullable();
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
        Schema::dropIfExists('collections');
    }
}
