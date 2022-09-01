<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$avatars = [
    'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
];

$factory->define(\App\Models\Video::class, function (Faker $faker) use ($avatars) {

    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'user_id' => random_int(1, 10),
        'title' => $faker->title,
        'video' => $faker->randomElement($avatars),
        'intro' => $faker->sentence,
        'qrcode' => $faker->randomElement($avatars),
        'share_title' => $faker->title,
        'share_img' => $faker->randomElement($avatars),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
