<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('newsletters', function (Blueprint $table) {
      $table->string('id')->unique()->default(uniqid("gb", false));
      $table->primary('id');
      $table->string('subject');
      $table->longText('body');
      $table->string('description')->nullable();
      $table->string('status')->nullable();
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
    Schema::dropIfExists('newsletters');
  }
}
