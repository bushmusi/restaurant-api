<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',50)->unique();
            $table->string('name_am',50)->unique();
            $table->bigInteger('si_unit_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();

            
            $table->foreign('si_unit_id')
                    ->references('id')->on('si_units')
                    ->onDelete('cascade');
            $table->string('type',20);

            $table->foreign('department_id')
                  ->references('id')->on('departments')
                  ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('stock_items');
    }
}
