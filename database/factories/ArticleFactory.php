<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $datetime = $faker->date . ' ' . $faker->time;
    return [
        'user_id' => random_int(1, 10),
        'title' => $faker->title,
        'content' => $faker->sentence,
        'created_at' => $datetime,
        'updated_at' => $datetime,
    ];
});
