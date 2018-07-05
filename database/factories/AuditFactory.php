<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Audit::class, function (Faker $faker) {
    $model = factory(array_random([
        \App\Models\Employer::class,
        \App\Models\WorkPosition::class,
    ]))->create();

    return [
        'user_type' => get_class($model),
        'user_id' => function () {
            return factory('App\Models\User')->create()->id;
        },
        'model_type' => get_class($model),
        'model_id' => $model->id,
        'event' => $faker->sentence(4),
        'changes' => json_encode($faker->sentence(4)),
        'ip' => $faker->ipv4
    ];
});
