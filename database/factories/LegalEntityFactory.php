<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LegalEntity::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
