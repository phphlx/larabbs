<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Record::class, function (Faker $faker) {
    $datetime = $faker->date . ' ' . $faker->time;
    return [
        'user_id' => random_int(1, 5),
        'admin_id' => random_int(1, 2),
        'money' => random_int(100, 200),
        'created_at' => $datetime,
        'updated_at' => $datetime,
    ];
});
