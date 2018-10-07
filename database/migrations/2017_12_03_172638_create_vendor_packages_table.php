<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('vendor_packages'))
      {
        Schema::create('vendor_packages', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('package_type', 60)->unique();
          $table->longtext('options');
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
      Schema::drop('vendor_packages');
    }
}