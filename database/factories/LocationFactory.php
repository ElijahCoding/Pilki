<?php

use App\Models\City;
use App\Models\CityDistrict;
use App\Models\Country;
use App\Models\Region;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name'     => $faker->unique()->country,
        'currency' => $faker->currencyCode,
    ];
});

$factory->define(Region::class, function (Faker $faker) {
    return [
        'country_id' => factory(Country::class),
        'name'       => $faker->region,
    ];
});

$factory->define(City::class, function (Faker $faker) {
    return [
        'region_id' => factory(Region::class),
        'name'      => $faker->city,
    ];
});

$factory->define(CityDistrict::class, function (Faker $faker) {
    return [
        'city_id' => factory(City::class),
        'name' => $faker->sentence,
    ];
});