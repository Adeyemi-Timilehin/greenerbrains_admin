<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('image')->nullable();
            $table->string('provider')->default("system");
            $table->string('provider_id')->default(uniqid("gb",false));
            $table->timestamp('email_verified_at')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->longText('api_token')->nullable();
            $table->longText('token')->nullable();
            $table->boolean('verified')->nullable()->default(false);
            $table->string('type')->nullable()->default('user');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
