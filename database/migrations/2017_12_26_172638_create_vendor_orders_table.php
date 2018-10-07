<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('vendor_orders'))
      {
        Schema::create('vendor_orders', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('order_id')->unsigned();
          $table->integer('vendor_id')->unsigned();
          $table->float('order_total', 11, 2);
          $table->float('net_amount', 11, 2);
          $table->string('order_status', 30);
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
      Schema::drop('vendor_orders');
    }
}