<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ServicePrice::class, function (Faker $faker) {
    return [
        'service_id' => function () {
          return factory('App\Models\Service')->create()->id;
        },
        'used_at' => null,
        'price' => rand(1, 10)
    ];
});
