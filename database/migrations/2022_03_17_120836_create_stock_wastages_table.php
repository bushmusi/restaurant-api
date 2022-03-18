<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_wastages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('stock_item_id')->unsigned();
            
            $table->integer('quantity')->unsigned();
            $table->dateTime('wastage_date');
            $table->boolean('isExpire');
            $table->string('remark',100);

            $table->foreign('stock_item_id')
                  ->references('id')->on('stock_items')
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
        Schema::dropIfExists('stock_wastages');
    }
}
