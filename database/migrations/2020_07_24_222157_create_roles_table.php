<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->string('id')->unique()->default(uniqid("gb", false));
            $table->primary('id');
            $table->string('label');
            $table->string('name')->unique();
            $table->timestamps();
        });

        // predefined roles
        $roles = ['admin', 'user', 'author'];
        $faker = Faker::create();
        for ($i = 0; $i < count($roles); $i++) {
            DB::table('roles')->insert([
                'id' => uniqid('gb', false),
                'name' => Str::slug($roles[$i]),
                'label' => $roles[$i],

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
        Schema::dropIfExists('roles');
    }
}
