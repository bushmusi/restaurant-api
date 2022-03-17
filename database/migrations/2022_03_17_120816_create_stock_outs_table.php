<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('stock_item_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();

            $table->integer('quantity')->unsigned();
            $table->dateTime('outdate');
            $table->string('remark',255);

            $table->foreign('stock_item_id')
                  ->references('id')->on('stock_items')
                  ->onDelete('cascade');

            $table->foreign('employee_id')
                  ->references('id')->on('employees')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('stock_outs');
    }
}
