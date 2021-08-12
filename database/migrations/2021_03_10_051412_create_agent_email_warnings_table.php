<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentEmailWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('agent_email_warnings')) {
            Schema::create('agent_email_warnings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('agent_application_id')->nullable();
                $table->integer('email_template_id')->nullable();
                $table->string('email_template_type', 250)->nullable();
                $table->date('date_sent');
                $table->text('referees')->nullable();
                $table->tinyInteger('is_sent')->default(0);
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
        Schema::dropIfExists('agent_email_warnings');
    }
}
