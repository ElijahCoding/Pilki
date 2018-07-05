<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Equipment::class, function (Faker $faker) {
    return [
        'unit_id' => function () {
          return factory('App\Models\Unit')->create()->id;
        },
        'legal_entity_id' => function() {
          return factory('App\Models\LegalEntity')->create()->id;
        },
        'title' => $faker->sentence(4),
        'comment' => $faker->sentence(4),
        'status' => 1
    ];
});
