<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('process_id', 10)->nullable();
            $table->string('form_type', 191)->nullable();
            $table->longText('form_json')->nullable();
            $table->string('form_txt', 191)->nullable();
            $table->date('date_created')->nullable();
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
        Schema::dropIfExists('external_forms');
    }
}
