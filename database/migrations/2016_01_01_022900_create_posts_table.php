<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('posts'))
      {
        Schema::create('posts', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('post_author_id')->unsigned();
          $table->longtext('post_content')->nullable();
          $table->string('post_title');
          $table->string('post_slug');
          $table->integer('parent_id')->unsigned();
          $table->integer('post_status')->unsigned();
          $table->string('post_type');
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
      Schema::drop('posts');
    }
}
