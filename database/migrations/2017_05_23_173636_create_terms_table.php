<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('terms'))
      {
        Schema::create('terms', function (Blueprint $table) {
          $table->increments('term_id')->unsigned();
          $table->string('name');
					$table->string('slug');
          $table->string('type');
					$table->integer('parent')->unsigned();
					$table->integer('status')->unsigned();
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
      Schema::drop('terms');
    }
}