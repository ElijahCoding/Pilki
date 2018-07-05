<?php

Route::group(['namespace' => 'App\Http\Controllers\Users', 'as' => 'users.'], function () {

    Route::get('/', 'IndexController@index')->name('index');

    /**
     * Authorization
     */
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::get('register', 'AuthController@register')->name('register');

        Route::get('password', 'AuthController@passwordRequest')->name('password.request');
        Route::get('password/reset', 'AuthController@passwordReset')->name('password.reset');

        Route::get('fill-form', 'AuthController@socialFillForm')->name('social.fill_form');
        Route::post('fill-form', 'AuthController@socialFillFormSave')->name('social.fill_form.save');

        Route::get('{provider}', 'AuthController@socialRedirect')->name('social.redirect');
        Route::get('{provider}/callback', 'AuthController@socialCallback')->name('social.callback');

    });

    /**
     * Profile
     */
    Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'as' => 'profile'], function () {
        Route::get('/', 'ProfileController@summary')->name('summary');
    });

});