<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('products'))
      {
        Schema::create('products', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('author_id')->unsigned();
          $table->longtext('content')->nullable();
          $table->string('title');
          $table->string('slug');
          $table->integer('status')->unsigned();
          $table->string('sku', 60)->nullable();
          $table->float('regular_price');
          $table->float('sale_price');
          $table->float('price');
          $table->integer('stock_qty')->unsigned();
          $table->string('stock_availability', 30);
          $table->string('type', 60);
          $table->string('image_url');
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
      Schema::drop('products');
    }
}
