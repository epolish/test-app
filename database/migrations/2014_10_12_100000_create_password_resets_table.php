<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // password resets table
    Schema::create('password_resets', function(Blueprint $table)
    {
      $table->string('email')->index();
      $table->string('token')->index();
      $table->timestamp('created_at');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // drop password resets table
    Schema::drop('password_resets');
  }

}
