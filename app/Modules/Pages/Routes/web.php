<?php

Route::namespace('Api\Client')->group(function(){
    Route::get('localization-text','LocalizationController@getLangFile');
    Route::prefix('static-page')->group(function(){
        Route::get('{module}','StaticPageController@index');
        Route::get('{module}/show/{id}','StaticPageController@show');
    });
    Route::prefix('page')->name('page.')->group(function(){
        Route::get('{module}','PageController@index')->name('index');
        Route::get('type','PageController@pageType');
    });

});
