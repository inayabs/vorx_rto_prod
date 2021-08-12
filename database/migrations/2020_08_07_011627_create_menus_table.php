<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('order')->nullable();
                $table->string('menu_name', 191)->nullable();
                $table->string('add_on_name', 191)->nullable();
                $table->string('fa_icon', 191)->nullable();
                $table->string('link', 191)->nullable();
                $table->tinyInteger('dropdown')->default(0);
                $table->tinyInteger('is_default')->default(1);
                $table->text('role_access')->default(json_encode(["Super-Admin", "Staff"]));
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
        Schema::dropIfExists('menus');
    }
}
