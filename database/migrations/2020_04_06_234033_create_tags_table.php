<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->timestamps();
        });

        $tags = ['science', 'art', 'politics'];
        $faker = Faker::create();
        for ($i = 0; $i < count($tags); $i++) {
            DB::table('tags')->insert([
                'id' => uniqid('gb', false),
                'name' => Str::slug($tags[$i]),
                'label' => $tags[$i],

                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
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
        Schema::dropIfExists('tags');
    }
}
