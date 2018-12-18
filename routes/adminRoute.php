<?php

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'request.log']], function () {
    Route::get('/', 'AdminController@index');
    Route::post('manage', 'AdminController@manage');
    Route::post('del', 'AdminController@del');
    Route::post('lock-modify', 'AdminController@lockStatusModify');

    Route::get('group', 'GroupController@index');
    Route::get('/group/manage', 'GroupController@manage');
    Route::post('save', 'GroupController@save');
    Route::post('/group/destroy', 'GroupController@destroy');
});
