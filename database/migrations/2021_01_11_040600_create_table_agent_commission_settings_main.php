<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAgentCommissionSettingsMain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commission_setting_mains', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->integer('agent_id');
            $table->integer('user_id');
            $table->enum('gst_type',['registered','not_registered']);
            $table->tinyInteger('gst_status');
            $table->date('registered_date');
            $table->integer('course_id');
            $table->decimal('commision_value',10,2);
            $table->enum('commission_type',['%','$']);
            $table->string('remarks');
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
        Schema::dropIfExists('agent_commission_setting_mains');
    }
}
