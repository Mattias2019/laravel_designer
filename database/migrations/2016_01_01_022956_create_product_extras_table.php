<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('product_extras'))
      {
        Schema::create('product_extras', function (Blueprint $table) {
          $table->increments('product_extra_id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->string('key_name')->nullable();
          $table->longtext('key_value')->nullable();
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
      Schema::drop('product_extras');
    }
}