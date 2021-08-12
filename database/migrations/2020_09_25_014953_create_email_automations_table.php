<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAutomationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('email_automations')) {
            Schema::create('email_automations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email', 255);
                $table->string('name', 255);
                $table->string('addOn', 255);
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
        Schema::dropIfExists('email_automations');
    }
}
