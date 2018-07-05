<?php

Route::group([
    'namespace'  => 'App\Http\Controllers\Api\Users',
    'as'         => 'api.users.',
    'prefix'     => 'users',
    'middleware' => 'api_users',
    'guard'      => 'api_users',
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('register', 'AuthController@register');
        Route::get('iam', 'AuthController@iam');
        Route::post('refresh', 'AuthController@refresh');
        Route::any('social_login', 'AuthController@socialLogin');
        Route::any('{provider}', 'AuthController@redirectToProvider');
        Route::post('fill-form', 'AuthController@socialFillFormSave');
    });
});


Route::group([
    'namespace'  => 'App\Http\Controllers\Api\Crm',
    'as'         => 'api.crm.',
    'prefix'     => 'crm',
    'middleware' => 'api_crm',
    'guard'      => 'api_employers',
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('iam', 'AuthController@iam');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('reset-password', 'AuthController@resetPassword');

    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('employers/form', 'EmployerController@form');
        Route::resource('employers/category', 'EmployerCategoryController');
        Route::resource('employers/{employer}/services', 'EmployerServiceController');
        Route::resource('employers/{employer}/window', 'EmployerWindowController');
        Route::get('employers/{employer}/schedule', 'EmployerScheduleController@get');
        Route::post('employers/{employer}/schedule', 'EmployerScheduleController@store');
        Route::post('employers/{employer}/schedule/{employer_schedule}/approve', 'EmployerScheduleController@approve');
        Route::delete('employers/{employer}/schedule/{employer_schedule}', 'EmployerScheduleController@delete');

        Route::get('employers/{employer}/permission', 'EmployerPermissionController@get');
        Route::post('employers/{employer}/permission', 'EmployerPermissionController@set');
        Route::resource('employers', 'EmployerController');

        Route::resource('country', 'CountryController');
        Route::resource('region', 'RegionController');
        Route::resource('city', 'CityController');
        Route::resource('metro', 'MetroController');
        Route::resource('district', 'CityDistrictController');

        Route::get('service/form', 'ServiceController@form');
        Route::resource('service/category', 'ServiceCategoryController');
        Route::resource('service/resource', 'ServiceResourceController');
        Route::resource('service', 'ServiceController');

        Route::resource('equipment/{equipment}/services', 'EquipmentServiceController');
        Route::resource('equipment/{equipment}/window', 'EquipmentWindowController');
        Route::resource('equipment', 'EquipmentController');

        Route::get('permission/access_types', 'PermissionController@accessTypes');
        Route::get('permission/groups', 'PermissionController@groups');
        Route::resource('permission', 'PermissionController')->only(['index']);

        Route::get('audits', 'AuditController@index');

        Route::resource('work_positions', 'WorkPositionController');
        Route::resource('work_position/{work_positions}/service', 'WorkPositionServiceController');
        Route::get('work_position/{work_positions}/service/create', 'WorkPositionServiceController@create');
        Route::delete('work_position/{work_positions}/service', 'WorkPositionServiceController@delete');
    });
});

Route::group([
    'namespace'  => 'App\Http\Controllers\Api',
    'as'         => 'api.',
    'middleware' => 'api',
], function () {
    Route::post('phone/confirm', ['uses' => 'PhoneController@confirm', 'as' => 'phone.confirm', 'laroute' => true]);
});