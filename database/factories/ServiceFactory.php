<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Service::class, function (Faker $faker) {
    return [
        'legal_entity_id' => function () {
          return factory('App\Models\LegalEntity')->create()->id;
        },
        'service_category_id' => function () {
          return factory('App\Models\ServiceCategory')->create()->id;
        },
        'title' => json_encode($faker->title),
        'title_online' => json_encode($faker->title),
        'title_cashier' => json_encode($faker->title),
        'article' => $faker->title,
        'barcode' => $faker->ean13,
        'duration' => $faker->randomNumber($nbDigits = NULL, $strict = false)
    ];
});
