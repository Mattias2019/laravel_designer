<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('request_products'))
      {
        Schema::create('request_products', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->string('name');
          $table->string('email');
          $table->string('phone_number');
          $table->longtext('description');
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
      Schema::drop('request_products');
    }
}