<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
          $table->string('id')->unique()->default(uniqid("gb", false));
          $table->primary('id');
          $table->string('title')->unique();
          $table->string('slug')->nullable()->unique();
          $table->longText('body');
          $table->longText('image')->nullable();
          $table->date('publish_date')->nullable();
          $table->string('status')->nullable();
          $table->unsignedInteger('user_id')->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
          $table->boolean('verified')->default(false);
          $table->unsignedBigInteger('likes')->nullable()->default(0);
          $table->unsignedBigInteger('views')->nullable()->default(0);
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
        Schema::dropIfExists('posts');
    }
}
