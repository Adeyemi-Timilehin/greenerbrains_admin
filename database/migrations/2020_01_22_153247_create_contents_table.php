<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('contents', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('title');
            $table->longText('body')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->string('media_id')->nullable();
            $table->string('category');
            $table->string('description')->nullable();
            $table->date('published_date')->nullable()->default(date('Y-m-d H:i:s'));
            $table->string('publisher_id')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('content_type')->default('text');
            $table->string('rating')->nullable()->default("3");
            $table->string('content_access')->default('free');
            $table->unsignedInteger('position')->nullable()->default(1);
            $table->string('slug')->nullable()->unique();
            $table->string('subject_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('contents');
    }
}
