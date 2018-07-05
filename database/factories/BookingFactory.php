<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Booking::class, function (Faker $faker) {
    return [
        'employer_window_id' => function () {
          return factory('App\Models\EmployerWindow')->create()->id;
        },
        'user_id' => function () {
          return factory('App\Models\User')->create()->id;
        }
    ];
});
