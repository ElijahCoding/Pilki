<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UnitGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
