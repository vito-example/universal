<?php

Route::name(config('cms.admin.base_route_name') . '.')->group(function(){

    Route::prefix('companies')->name('company.')->group(function(){
        $controller = 'CompanyController';
        $moduleName = 'company';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status');
    });

    Route::prefix('company-activities')->name('company_activity.')->group(function(){
        $controller = 'CompanyActivityController';
        $moduleName = 'company_activity';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status');
    });

    Route::prefix('company-employees')->name('company_employee.')->group(function(){
        $controller = 'CompanyEmployeeController';
        $moduleName = 'company_employee';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::get('/export', $controller . '@export')->name('export')->middleware(['permission:'.getPermissionKey($moduleName, 'export', false)]);

    });

});
