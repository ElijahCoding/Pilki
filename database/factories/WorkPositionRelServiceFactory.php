<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\WorkPositionRelService::class, function (Faker $faker) {
    $serviceModel = array_random([
        \App\Models\Service::class,
        \App\Models\ServiceCategory::class,
    ]);

    return [
        'service_type' => $serviceModel,
        'service_id'   => $serviceModel->id
    ];
});
