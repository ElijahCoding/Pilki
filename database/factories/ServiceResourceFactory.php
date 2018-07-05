<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ServiceResource::class, function (Faker $faker) {
    return [
        'service_id' => function () {
          return factory('App\Models\Service')->create()->id;
        },
        'legal_entity_id' => function () {
          return factory('App\Models\LegalEntity')->create()->id;
        },
        'type' => $faker->title,
        'count' => $faker->randomDigitNotNull()
    ];
});
