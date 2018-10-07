<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('term_extras'))
      {
        Schema::create('term_extras', function (Blueprint $table) {
          $table->increments('term_extra_id')->unsigned();
					$table->integer('term_id')->unsigned();
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
      Schema::drop('term_extras');
    }
}