<?php

Route::name(config('cms.admin.base_route_name') . '.')->group(function(){
    Route::prefix('blog')->name('blog.')->group(function(){
        $controller = 'BlogController';
        $moduleName = 'blog';
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status');
    });
    Route::name('subscriber.')->prefix('subscribers')->group(function() {
        $contrl = 'SubscriberController';
        Route::get('/', $contrl . '@index')->name('index');
        Route::get('/export', $contrl . '@export')->name('export');
    });
    Route::name('page.')->prefix('pages')->group(function() {
        $contrl = 'PageController';
        Route::post('/create-data', $contrl . '@createData')->name('create_data');
        Route::get('/edit/{type?}', $contrl . '@edit')->name('edit');
        Route::post('/store', $contrl . '@store')->name('store');
    });
});
