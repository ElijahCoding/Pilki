<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\EmployerSchedule::class, function (Faker $faker) {
    return [
        'employer_id'  => function () {
            return factory('App\Models\Employer')->create()->id;
        },
        'unit_id'      => function () {
            return factory('App\Models\Unit')->create()->id;
        },
        'equipment_id' => function () {
            return factory('App\Models\Equipment')->create()->id;
        },
        'begin_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        'end_at'       => Carbon::tomorrow()->format('Y-m-d H:i:s'),
        'status'       => array_random(\App\Models\EmployerSchedule::getStatuses()),
    ];
});
