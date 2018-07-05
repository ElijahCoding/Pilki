<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Metro::class, function (Faker $faker) {
    return [
        'city_id' => function () {
            return factory('App\Models\City')->create()->id;
        },
        'name' => $faker->sentence(4)
    ];
});
