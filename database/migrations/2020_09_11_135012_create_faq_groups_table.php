<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateFaqGroupsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('faq_groups', function (Blueprint $table) {
      $table->increments('id');
      $table->longText('label');
      $table->longText('name');
      $table->longText('description')->nullable();
      $table->boolean('is_published')->default(true);
      $table->timestamps();
    });

    $groups = ['Getting Started', 'User Guide', 'Pricing Plan'];
    
    for ($i = 0; $i < count($groups); $i++) {
      DB::table('faq_groups')->insert([
        'name' => Str::slug($groups[$i]),
        'label' => $groups[$i],
        'description' => "FAQ Group",
        'is_published' => true
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
    Schema::dropIfExists('faq_groups');
  }
}
