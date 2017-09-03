<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ads extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // ads table
    Schema::create('ads', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('author_id')->unsigned()->default(0);
      $table->foreign('author_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
      $table->string('title')->unique();
      $table->text('description');
      $table->string('slug')->unique();
      $table->boolean('active');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // drop ads table
    Schema::drop('ads');
  }

}
