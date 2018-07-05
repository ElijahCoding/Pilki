<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Permission::class, function (Faker $faker) {
    $accessModel = factory(array_random((new PermissionSeeder)->getModels()))->create();

    return [
        'model'       => get_class($accessModel),
        'action'      => $accessModel->id,
        'description' => 'post things',
    ];
});

$factory->define(\App\Models\PermissionGroup::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});
