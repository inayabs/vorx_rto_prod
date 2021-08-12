<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAgentCommissionSettingsSubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commission_setting_subs', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('student_id');
            $table->decimal('commission_limit',10,2);
            $table->enum('gst_type',['registered','not_registered']);
            $table->tinyInteger('gst_status');
            $table->date('registered_date');
            $table->integer('course_id');
            $table->decimal('commision_value',10,2);
            $table->enum('commission_type',['%','$']);
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
       Schema::dropIfExists('agent_commission_setting_subs');
    }
}
