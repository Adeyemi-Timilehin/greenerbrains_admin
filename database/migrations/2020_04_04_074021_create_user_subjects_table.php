<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_subject', function (Blueprint $table) {
      $table->unsignedInteger('user_id');
      // $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->string('subject_id');
      $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
      // $table->foreign('subject_id')
      //     ->references('id')
      //     ->on('subjects')
      //     ->onDelete('cascade');
      $table->string('status');

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
    Schema::dropIfExists('user_subject');
  }
}
