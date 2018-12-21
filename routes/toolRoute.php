<?php

Route::group(['prefix' => 'tool', 'middleware' => ['auth', 'request.log']], function () {

    Route::get('banner', 'ToolController@banner');
    Route::post('banner/add', 'ToolController@banner_add');
    Route::post('banner/editok', 'ToolController@banner_editok');
    Route::get('banner/delete', 'ToolController@banner_delete');
    Route::get('banner/ajax', 'ToolController@banner_ajax');

    Route::get('launcher/banner', 'ToolController@launcher_banner');
    Route::post('launcher/banner/add', 'ToolController@launcher_banner_add');
    Route::post('launcher/banner/editok', 'ToolController@launcher_banner_editok');
    Route::get('launcher/banner/delete', 'ToolController@launcher_banner_delete');
    Route::get('launcher/banner/ajax', 'ToolController@launcher_banner_ajax');

    Route::get('bulletins', 'ToolController@bulletins');
    Route::get('bulletins/add', 'ToolController@bulletins_add');
    Route::post('bulletins/do_add', 'ToolController@do_bulletins_add');
    Route::get('bulletins/edit', 'ToolController@bulletins_edit');
    Route::post('bulletins/do_edit', 'ToolController@do_bulletins_edit');
    Route::get('bulletins/delete', 'ToolController@bulletins_delete');
    Route::get('bulletins/ajax', 'ToolController@bulletins_ajax');

    Route::get('marquee', 'ToolController@marquee');
    Route::post('marquee/edit', 'ToolController@marquee_edit');
    Route::post('marquee/add', 'ToolController@marquee_add');
    Route::post('marquee/delete', 'ToolController@marquee_delete');
    Route::get('marquee/ajax', 'ToolController@marquee_ajax');

    Route::get('recommend', 'RecommendController@index');
    Route::get('recommend/info', 'RecommendController@info');
    Route::get('recommend/ins', 'RecommendController@insRecommend');
    Route::get('recommend/top', 'RecommendController@upRecommendTop');
    Route::get('recommend/del', 'RecommendController@recommendDel');
    Route::get('recommend/sort', 'RecommendController@recommendSort');

    Route::get('viplist', 'ViplistController@index');
    Route::get('viplist/info', 'ViplistController@info');
    Route::get('viplist/up', 'ViplistController@upVip');
    Route::get('viplist/upThree', 'ViplistController@upVipThreeDay');

    Route::get('friendShare', 'EventController@friendShare');
    Route::get('friendShare/info', 'EventController@friendShareInfo');
    Route::get('friendShare/up', 'EventController@friendShareUp');
    Route::get('friendShare/del', 'EventController@friendShareDel');

    // 影片分享獎勵
    Route::get('videoShare', 'EventController@videoShare');
    Route::get('videoShare/info', 'EventController@videoShareInfo');
    Route::get('videoShare/up', 'EventController@videoShareUp');
    Route::get('videoShare/del', 'EventController@videoShareDel');

    Route::get('mailsSender', 'EventController@mailsSender');
    Route::get('mailsSender/ins', 'EventController@mailsSenderIns');
    Route::post('mailsSender/import', 'EventController@mailsSenderImport');
    Route::get('mailsSender/import_sample', 'EventController@mailsSenderExportSampleImport');
    Route::get('mailsSender/export', 'EventController@mailsSenderExport');

    Route::get('imageUpload', 'UploadController@imageIndex');
    Route::get('upload/addParent/{type}', 'UploadController@addParent');
    Route::post('imageUpload/act', 'UploadController@imageUpload');

    // 影片編輯器
    Route::get('videoUpload', 'UploadController@videoIndex');
    Route::get('upload/addParent/{type}', 'UploadController@addParent');
    Route::post('videoUpload/act', 'UploadController@videoUpload');
    Route::post('upload/delParent', 'UploadController@delParent');
    Route::post('upload/delSub', 'UploadController@delSub');

    Route::get('maintain', 'ToolController@maintain');
    Route::get('maintain/up', 'ToolController@upMaintain');
    Route::get('maintain/up/fw', 'ToolController@upFireWall');

    Route::get('proxy', 'ProxyController@index');
    Route::get('proxy/info', 'ProxyController@info');
    Route::get('proxy/ins', 'ProxyController@proxyIns');
    Route::get('proxy/visibility', 'ProxyController@proxyVisibility');
    Route::get('proxy/status', 'ProxyController@proxyStatus');
    Route::get('proxy/del', 'ProxyController@proxyDel');

    // 世界排行榜設定
    Route::get('rank-setting', 'RankController@index');
    Route::get('rank-setting/award', 'RankController@award');
    Route::get('rank-setting/new-cycle-templete', 'RankController@newCycleTemplete');
    Route::post('rank-setting/modify-cycle', 'RankController@modifyCycle');
    Route::post('rank-setting/del-cycle', 'RankController@delCycle');
    Route::get('rank-setting/new-type-templete', 'RankController@newTypeTemplete');
    Route::post('rank-setting/modify-type', 'RankController@modifyType');
    Route::post('rank-setting/del-type', 'RankController@delType');
    Route::post('rank-setting/modify-rank', 'RankController@modifyRank');
    Route::get('rank-setting/get-types-of-cycle', 'RankController@getTypesOfCycle');
    Route::post('rank-setting/del-rank', 'RankController@delRank');
    Route::get('rank-setting/rank-award-info', 'RankController@rankAwardInfo');
    Route::post('rank-setting/del-award', 'RankController@delAward');
    Route::post('rank-setting/modify-award', 'RankController@modifyAward');

    // 新手指南
    Route::get('novice-bulletins', 'ToolController@noviceBulletins');
    Route::post('novice-bulletins/add', 'ToolController@noviceBulletinsAdd');
    Route::post('novice-bulletins/editok', 'ToolController@noviceBulletinsEditOk');
    Route::get('novice-bulletins/delete', 'ToolController@noviceBulletinsDelete');
    Route::get('novice-bulletins/ajax', 'ToolController@noviceBulletinsAjax');
});

// 營運數值設定
Route::group(['prefix' => 'game-setting', 'middleware' => ['auth', 'request.log']], function () {
    Route::get('/', 'SettingController@index');
    Route::post('save', 'SettingController@saveSetting');
    Route::post('vip-save', 'SettingController@saveVipSetting');
});
