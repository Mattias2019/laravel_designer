<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaveCustomDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('save_custom_designs'))
      {
        Schema::create('save_custom_designs', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('product_id')->unsigned();
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
      Schema::drop('save_custom_designs');
    }
}
