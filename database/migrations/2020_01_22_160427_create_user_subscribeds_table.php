<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscribedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscribeds', function (Blueprint $table) {
            // $table->string('id')->unique()->default(uniqid("gb", false));
            // $table->primary('id');
            $table->string('user_id');
            $table->string('subject_id');
            // $table->foreign('subject_id')
            //     ->references('id')
            //     ->on('contents')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

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
        Schema::dropIfExists('user_subscribeds');
    }
}
