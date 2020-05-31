<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
    	'user_id' => $faker->numberBetween($min = 1, $max = 4),
    	'body' => $faker->realText(17),
		'created_at' => now(),
		'updated_at' => now(),
        //
    ];
});
