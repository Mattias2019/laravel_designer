<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('user_role_permissions'))
      {
        Schema::create('user_role_permissions', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('role_id')->unsigned();
          $table->longtext('permissions');
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
      Schema::drop('user_role_permissions');
    }
}
