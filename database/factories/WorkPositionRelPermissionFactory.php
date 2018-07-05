<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\WorkPositionRelPermission::class, function (Faker $faker) {

    $permissionModel = array_random([
        \App\Models\Permission::class,
    ]);

    $maxId = $permissionModel::query()->max('id');

    return [
        'permission_type' => $permissionModel,
        'permission_id'   => $faker->unique()->numberBetween(1, $maxId),
    ];
});
