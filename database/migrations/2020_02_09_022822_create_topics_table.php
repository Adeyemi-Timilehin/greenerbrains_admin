<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('topics', function (Blueprint $table) {
    //         $table->string('id')->unique()->default(uniqid("gb", false));
    //         $table->primary('id');
    //         $table->string('name')->unique();
    //         $table->string('label');
    //         $table->string('description')->nullable();
    //         $table->string('category')->nullable();
    //         $table->string('sub_category')->nullable();
    //         $table->timestamps();
    //     });

    //     $topics = ['Chlorine', 'Chemical Equations', 'Organic Chemistry'];
    //     $faker = Faker::create();
    //     for ($i = 0; $i < count($topics); $i++) {
    //         DB::table('topics')->insert([
    //             'id' => uniqid('gb', false),
    //             'name' => Str::slug($topics[$i]),
    //             'label' => $topics[$i],

    //             'created_at' => $faker->dateTime($max = 'now', $timezone = null),
    //             'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    //         ]);
    //     }
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('topics');
    // }
}
