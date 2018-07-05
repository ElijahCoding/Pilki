<?php

use Faker\Generator as Faker;

$factory->define(App\Models\City::class, function (Faker $faker) {
    return [
        'region_id' => function () {
          return factory('App\Models\Region')->create()->id;
        },
        'name' => $faker->city
    ];
});
