<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Image::class, function (Faker $faker) {
    return [
        'disk' => $faker->sentence(4),
        'filename' => $faker->sentence(8),
        'sort' => rand(1, 100),
    ];
});
