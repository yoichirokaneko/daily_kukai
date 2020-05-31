<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' => $faker->numberBetween($min = 1, $max = 5),
    	'body' => $faker->realText(17),
		'created_at' => now(),
		'updated_at' => now(),
    ];
});
