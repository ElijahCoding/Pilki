<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Window::class, function (Faker $faker) {
    return [
        'unit_id' => function () {
          return factory('App\Models\Unit')->create()->id;
        },
        'employer_id' => function () {
          return factory('App\Models\Employer')->create()->id;
        },
        'equipment_id' => function () {
          return factory('App\Models\Equipment')->create()->id;
        },
        'booking_id' => function () {
          return factory('App\Models\Equipment')->create()->id;
        },
        'begin_at' => Carbon::now(),
        'end_at' => Carbon::tomorrow(),
        'duration_original' => $faker->randomDigit,
        'duration' => $faker->randomDigit
    ];
});
