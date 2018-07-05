<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\EmployerRelPermission::class, function (Faker $faker) {

    $permissionModel = factory(array_random([
        \App\Models\Permission::class,
        \App\Models\PermissionGroup::class,
        \App\Models\WorkPosition::class,
    ]))->create();

    $accessModel = factory(array_random(App\Models\EmployerRelPermission::$accessTypes))->create();

    return [
        'employer_id'     => function () {
            return factory('App\Models\Employer')->create()->id;
        },
        'permission_type' => get_class($permissionModel),
        'permission_id'   => $permissionModel->id,
        'access_type'     => get_class($accessModel),
        'access_id'       => $accessModel->id,
        'date_from'       => Carbon::now(),
    ];
});
