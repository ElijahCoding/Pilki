<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\EquipmentWindow::class, function (Faker $faker) {
    return [
        'equipment_id' => function () {
            return factory(\App\Models\Equipment::class)->create()->id;
        },
        'begin_at'     => Carbon::now(),
        'schedule'     => [
            0,
            3600,
        ],
    ];
});
