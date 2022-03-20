<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuCatagoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_catagories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menus_id')->unsigned();
            $table->bigInteger('catagories_id')->unsigned();

            $table->foreign('menus_id')
                   ->references('id')->on('menus');
            $table->foreign('catagories_id')
                  ->references('id')->on('catagories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_catagories');
    }
}
