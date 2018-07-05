<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserSocial::class, function (Faker $faker) {
    return [
        'user_id' => function () {
          return factory('App\Models\User')->create()->id;
        },
        'provider' => $faker->randomElement(['vkontakte', 'google', 'twitter', 'instagram', 'faceboook']),
        'provider_user_id' => $faker->unixTime(),

    ];
});
