<?php

use App\Models\City;
use App\Models\CityDistrict;
use App\Models\LegalEntity;
use Faker\Generator as Faker;

$factory->define(App\Models\Unit::class, function (Faker $faker) {
    return [
        'name'            => $faker->company,
        'location_type'   => array_random([City::class, CityDistrict::class]),
        'location_id'     => rand(1, 10),
        'legal_entity_id' => factory(LegalEntity::class),
        'address'         => $faker->address,
        'latitude'        => $faker->latitude,
        'longitude'       => $faker->longitude,
    ];
});
