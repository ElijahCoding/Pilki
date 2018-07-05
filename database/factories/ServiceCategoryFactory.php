<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ServiceCategory::class, function (Faker $faker) {
    return [
        'title' => json_encode($faker->title),
        'legal_entity_id' => function () {
          return factory('App\Models\LegalEntity')->create()->id;
        },
    ];
});
