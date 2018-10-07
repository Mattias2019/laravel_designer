<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCustomDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('users_custom_designs'))
      {
        Schema::create('users_custom_designs', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->integer('order_id')->unsigned();
          $table->text('access_token');
          $table->longtext('design_images');
          $table->longtext('design_data');
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
      Schema::drop('users_custom_designs');
    }
}
