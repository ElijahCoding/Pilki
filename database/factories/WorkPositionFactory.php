<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WorkPosition::class, function (Faker $faker) {
    return [
        'title'           => $faker->word,
        'legal_entity_id' => function () {
            return factory('App\Models\LegalEntity')->create()->id;
        },
    ];
});
