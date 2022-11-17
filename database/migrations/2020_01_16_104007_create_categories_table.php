<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->longText('description')->nullable();
            $table->longText('image')->nullable();

            $table->timestamps();
        });

        $categories = ['Foundation','G-Classic', 'Greener Pro', 'G-Tab'];
        $faker = Faker::create();
        for ($i = 0; $i < count($categories); $i++) {
            DB::table('categories')->insert([
                'id' => uniqid('gb', false),
                'name' => Str::slug($categories[$i]),
                'label' => $categories[$i],

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
        Schema::dropIfExists('categories');
    }
}
