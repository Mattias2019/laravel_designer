<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('users'))
      {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('display_name');
          $table->string('name', 60)->unique();
          $table->string('email', 128)->unique();
          $table->string('password', 60);
          $table->string('user_photo_url')->nullable();
          $table->integer('user_status')->unsigned();
          $table->string('secret_key');
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
        Schema::drop('users');
    }
}
