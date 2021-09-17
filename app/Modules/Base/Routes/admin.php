<?php



Route::name(config('cms.admin.base_route_name') . '.')->group(function(){
    Route::name('image.')->prefix('images')->group(function(){
        Route::post('/upload',  'ImageController@uploadImage')->name('upload');
    });
});
