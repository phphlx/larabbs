<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Salesperson;
use Faker\Generator as Faker;

$factory->define(Salesperson::class, function (Faker $faker) {
    return [
        'name' => $faker->name()
    ];
});
