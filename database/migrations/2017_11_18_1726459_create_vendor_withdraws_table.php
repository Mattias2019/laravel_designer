<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('vendor_withdraws'))
      {
        Schema::create('vendor_withdraws', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->float('amount');
          $table->float('custom_amount');
          $table->string('status', 30);
          $table->string('payment_type', 60);
          $table->string('payment_method', 60);
          $table->string('ip', 60);
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
      Schema::drop('vendor_withdraws');
    }
}