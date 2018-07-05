<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PermissionGroup::class, function (Faker $faker) {
    return [
        'title' => $faker->title
    ];
});
