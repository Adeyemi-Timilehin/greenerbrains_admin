<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTestimonialsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('testimonials', function (Blueprint $table) {
      $table->string('id')->unique()->default(uniqid("gb", false));
      $table->primary('id');
      $table->longText('name');
      $table->longText('body');
      $table->string('image')->nullable();
      $table->unsignedInteger('rating')->nullable()->default(5);
      $table->boolean('verified')->nullable()->default(false);
      $table->string('email')->nullable();
      $table->timestamps();
    });

    $ts = [
      [
        "name" => "Elizabeth_   from Onitsha, mother of two",
        "rating" => 5,
        "body" => "I never knew that an App would help me teach my kids how to solve problems in maths that I have tried without Success. Thank you James.",
        "image" => null,
        "email" => null
      ],
      [
        "name" => "Gina_   from Lagos Mother of four.",
        "rating" => 5,
        "body" => "I have a son who is 10,  ever since I introduced him to Greenerbrains App, his performance has greatly increased and he understands more when he reads.",
        "image" => null,
        "email" => null
      ],
      [
        "name" => "Maryjane_  A student in FUTO",
        "rating" => 5,
        "body" => "GreenerBrains has used this App to bless me. I am a university student approaching a graduating class. I use to have this problem of reading and forgetting every time but ever since I started using Greenerbrains App, reading and recalling has now become a reality. I'm so happy.",
        "image" => null,
        "email" => null
      ]
    ];

    for ($i = 0; $i < count($ts); $i++) {
      // Add to database
      DB::table('testimonials')->insert([
        'id' => uniqid('gb', false),
        'name' => $ts[$i]['name'],
        'rating' => $ts[$i]['rating'],
        'body' => $ts[$i]['body'],
        'image' => $ts[$i]['image'],
        'email' => $ts[$i]['email'],
        'verified' => true
      ]);
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('testimonials');
  }
}
