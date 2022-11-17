<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // App reviews table
    Schema::create('reviews', function (Blueprint $table) {
      $table->string('id')->unique()->default(uniqid("gb", false));
      $table->primary('id');
      $table->unsignedInteger('user_id');
      $table->string('subject_id');
      $table->string('name');
      $table->unsignedInteger('rating');
      $table->longText('message');
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
    Schema::dropIfExists('reviews');
  }
}
