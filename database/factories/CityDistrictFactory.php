<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CityDistrict::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'city_id' => function () {
          return factory('App\Models\City')->create()->id;
        }
    ];
});
