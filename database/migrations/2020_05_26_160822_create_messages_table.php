<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Contact us messages table
    Schema::create('messages', function (Blueprint $table) {
      $table->string('id')->unique()->default(uniqid("gb", false));
      $table->primary('id');
      $table->string('subject')->nullable();
      $table->string('name');
      $table->string('email');
      $table->longText('body');
      $table->string('ip_address')->nullable();
      $table->boolean('opened')->nullable()->default(false);
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
    Schema::dropIfExists('messages');
  }
}
