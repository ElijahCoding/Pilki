<?php

Route::group(['guard' => 'employers'], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });


    Route::group(['middleware' => 'auth:employers'], function () {
        Route::group(['prefix' => 'unit', 'as' => 'unit.'], function () {
            Route::get('/', 'UnitController@index')->name('index');
        });
    });

    Route::get('/', 'IndexController@index')->name('index');
});