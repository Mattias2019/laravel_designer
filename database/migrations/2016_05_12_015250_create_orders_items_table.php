<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('orders_items'))
      {
        Schema::create('orders_items', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('order_id')->unsigned();
          $table->longtext('order_data');
          $table->timestamps();
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
      Schema::drop('orders_items');
    }
}
