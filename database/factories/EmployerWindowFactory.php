<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\EmployerWindow::class, function (Faker $faker) {
    return [
        'employer_id' => function () {
          return factory('App\Models\Employer')->create()->id;
        },
        'service_category_id' => function () {
          return factory('App\Models\ServiceCategory')->create()->id;
        },
        'begin_at' => Carbon::now(),
        'end_at' => Carbon::tomorrow(),
        'schedule' => json_encode($faker->word)
    ];
});
