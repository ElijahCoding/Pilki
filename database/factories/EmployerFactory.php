<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Employer::class, function (Faker $faker) {
    static $first = true;
    $isSuperUser = $first;
    $first = false;

    if (env('APP_ENV') === 'testing') {
        return [
            'first_name'       => $faker->firstName,
            'middle_name'      => '',
            'last_name'        => $faker->lastName,
            'schedule_type'    => array_rand(\App\Models\Employer::getScheduleTypes()),
            'status'           => array_rand(\App\Models\Employer::getStatuses()),
            'unit_id'          => function () {
                return factory('App\Models\Unit')->create()->id;
            },
            'legal_entity_id'  => function () {
                return factory('App\Models\LegalEntity')->create()->id;
            },
            'work_position_id' => function () {
                return factory('App\Models\WorkPosition')->create()->id;
                // return \App\Models\WorkPosition::inRandomOrder()->first()->id;
            },
            'region_id'        => function () {
                return factory('App\Models\Region')->create()->id;
            },
            'metro_id'         => function () {
                return factory('App\Models\Metro')->create()->id;
            },
            'phone'            => $faker->unique()->e164PhoneNumber,
            'email'            => $faker->unique()->safeEmail,
            'password'         => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'remember_password'         => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret.
            'is_superuser'     => $isSuperUser,
            'remember_token'   => str_random(),

        ];
    } else {
        return [
            'first_name'       => $faker->firstName,
            'middle_name'      => '',
            'last_name'        => $faker->lastName,
            'schedule_type'    => array_rand(\App\Models\Employer::getScheduleTypes()),
            'status'           => array_rand(\App\Models\Employer::getStatuses()),
            'unit_id'          => function () {
                return factory('App\Models\Unit')->create()->id;
            },
            'legal_entity_id'  => function () {
                return factory('App\Models\LegalEntity')->create()->id;
            },
            'work_position_id' => function () {
                // return factory('App\Models\WorkPosition')->create()->id;
                return \App\Models\WorkPosition::inRandomOrder()->first()->id;
            },
            'region_id'        => function () {
                return factory('App\Models\Region')->create()->id;
            },
            'phone'            => $faker->unique()->e164PhoneNumber,
            'email'            => $faker->unique()->safeEmail,
            'password'         => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret.
            'remember_password'         => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'is_superuser'     => $isSuperUser,
            'remember_token'   => str_random(),
        ];
    }


});
