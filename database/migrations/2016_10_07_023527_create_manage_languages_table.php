<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('manage_languages'))
      {
        Schema::create('manage_languages', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('lang_name');
          $table->string('lang_code');
          $table->string('lang_sample_img');
          $table->integer('status')->unsigned();
          $table->integer('default_lang')->unsigned();
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
      Schema::drop('manage_languages');
    }
}
