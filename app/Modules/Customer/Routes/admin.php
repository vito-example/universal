<?php

Route::name(config('cms.admin.base_route_name') . '.')->group(function(){

    Route::prefix('customers')->name('customer.')->group(function(){
        $controller = 'CustomerController';
        $moduleName = 'customer';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('show/{id?}', $controller . '@show')->name('show_profile')->middleware(['permission:'.getPermissionKey($moduleName, 'show_profile', false)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/export', $controller . '@export')->name('export')->middleware(['permission:'.getPermissionKey($moduleName, 'export', false)]);
        Route::get('/login-as-customer/{id}', $controller . '@loginAsCustomer')->name('login_as_customer')->middleware(['permission:'.getPermissionKey($moduleName, 'login_as_customer', false)]);
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status')->middleware(['permission:'.getPermissionKey($moduleName, 'update_status', false)]);
    });



    Route::prefix('directions')->name('direction.')->group(function(){
        $controller = 'DirectionController';
        $moduleName = 'direction';
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status');
        Route::get('/search', $controller . '@search')->name('search');
    });

    Route::prefix('lecturers')->name('lecturer.')->group(function(){
        $controller = 'LecturerController';
        $moduleName = 'lecturer';
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status');
        Route::get('/search', $controller . '@search')->name('search');
        Route::get('/export', $controller . '@export')->name('export')->middleware(['permission:'.getPermissionKey($moduleName, 'export', false)]);

    });
});
