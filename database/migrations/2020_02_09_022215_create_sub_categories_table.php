<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->string('description')->nullable();
            $table->string('category_id')->nullable();
            $table->timestamps();
        });

        $sub_categories = ['Physics', 'Chemistry', 'Biology','Further Mathematics','Basic Science'];
        $faker = Faker::create();
        for ($i = 0; $i < count($sub_categories); $i++) {
            DB::table('sub_categories')->insert([
                'id' => uniqid('gb', false),
                'name' => Str::slug($sub_categories[$i]),
                'label' => $sub_categories[$i],

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
        Schema::dropIfExists('sub_categories');
    }
}
