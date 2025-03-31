<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $datetime = $faker->dayOfWeek;
    return [
        'user_id' => random_int(1, 10),
        'title' => $faker->catchPhrase,
        'content' => $faker->sentence,
        'created_at' => $datetime,
        'updated_at' => $datetime,
    ];
});
