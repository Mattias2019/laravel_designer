<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('object_relationships'))
      {
        Schema::create('object_relationships', function (Blueprint $table) {
          $table->integer('term_id')->unsigned();
          $table->integer('object_id')->unsigned();
          $table->primary(array('term_id', 'object_id'));
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
      Schema::drop('object_relationships');
    }
}