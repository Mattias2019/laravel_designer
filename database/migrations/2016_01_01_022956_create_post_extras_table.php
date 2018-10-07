<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('post_extras'))
      {
        Schema::create('post_extras', function (Blueprint $table) {
          $table->increments('post_extra_id')->unsigned();
          $table->integer('post_id')->unsigned();
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
      Schema::drop('post_extras');
    }
}
