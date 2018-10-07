<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('vendor_totals'))
      {
        Schema::create('vendor_totals', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('vendor_id')->unsigned();
          $table->float('totals', 11, 2);
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
      Schema::drop('vendor_totals');
    }
}