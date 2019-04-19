<?php

Route::group(['prefix' => 'tool', 'middleware' => ['auth', 'request.log']], function () {

    Route::get('banner', 'ToolController@banner');
    Route::post('banner/add', 'ToolController@banner_add');
    Route::post('banner/edit', 'ToolController@banner_edit');
    Route::get('banner/delete', 'ToolController@banner_delete');
    Route::get('banner/ajax', 'ToolController@banner_ajax');

    Route::get('launcher/banner', 'ToolController@launcher_banner');
    Route::post('launcher/banner/add', 'ToolController@launcher_banner_add');
    Route::post('launcher/banner/edit', 'ToolController@launcher_banner_edit');
    Route::get('launcher/banner/delete', 'ToolController@launcher_banner_delete');
    Route::get('launcher/banner/ajax', 'ToolController@launcher_banner_ajax');

    Route::get('ingame/banner', 'ToolController@ingame_banner');
    Route::post('ingame/banner/add', 'ToolController@ingame_banner_add');
    Route::post('ingame/banner/edit', 'ToolController@ingame_banner_edit');
    Route::get('ingame/banner/delete', 'ToolController@ingame_banner_delete');
    Route::get('ingame/banner/ajax', 'ToolController@ingame_banner_ajax');

    Route::post('bulletins/do_edit', 'ToolController@do_bulletins_edit');
    Route::get('bulletins/delete', 'ToolController@bulletins_delete');
    Route::get('bulletins/ajax', 'ToolController@bulletins_ajax');
    Route::post('bulletins/do_add', 'ToolController@do_bulletins_add');
    Route::get('bulletins/{game}', 'ToolController@bulletins');
    Route::get('bulletins/add/{game}', 'ToolController@bulletins_add');
    Route::get('bulletins/edit/{game}', 'ToolController@bulletins_edit');

    Route::post('events/do_edit', 'ToolController@do_events_edit');
    Route::get('events/delete', 'ToolController@events_delete');
    Route::get('events/ajax', 'ToolController@events_ajax');
    Route::post('events/do_add', 'ToolController@do_events_add');
    Route::get('events/{game}', 'ToolController@events');
    Route::get('events/add/{game}', 'ToolController@events_add');
    Route::get('events/edit/{game}', 'ToolController@events_edit');

    Route::get('imageUpload', 'UploadController@imageIndex');
    Route::get('upload/addParent/{type}', 'UploadController@addParent');
    Route::post('imageUpload/act', 'UploadController@imageUpload');
});
