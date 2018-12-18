<?php

Route::Auth();
Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'password', 'middleware' => ['auth', 'request.log']], function () {
    Route::get('/', 'Auth\PasswordController@index');
    Route::get('own', 'Auth\PasswordController@ownReset');
    Route::post('reseting', 'Auth\PasswordController@reseting');
});

Route::group(['prefix' => 'register', 'middleware' => ['auth', 'request.log']], function () {
    Route::get('/', 'RegisterController@index');
    Route::post('save', 'RegisterController@save');
});
