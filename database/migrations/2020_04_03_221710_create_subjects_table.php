<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('summary')->nullable();
            $table->string('category')->nullable();
            $table->string('rating')->nullable();
            $table->unsignedBigInteger('likes')->nullable();
            $table->unsignedBigInteger('views')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('thumbnail')->nullable();
            $table->string('preview_video')->nullable();
            $table->string('publisher_id')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('access')->nullable()->default('free');
            $table->string('language')->nullable()->default('english');
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
        Schema::dropIfExists('subjects');
    }
}
