<?php

Route::name(config('cms.admin.base_route_name') . '.')->group(function(){

    Route::prefix('event')->name('event.')->group(function(){
        $controller = 'EventController';
        $moduleName = 'event';
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/calendar', $controller . '@calendar')->name('calendar')->middleware(['permission:'.getPermissionKey($moduleName, 'calendar', false)]);
        Route::get('/calendar-data', $controller . '@getCalendarData')->name('calendar_data')->middleware(['permission:'.getPermissionKey($moduleName, 'calendar', false)]);
        Route::get('/attendees/{id}', $controller . '@attendees')->name('attendees')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);;
        Route::get('/show-questions/{id}', $controller . '@showQuestions')->name('show_questions');
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/update-status', $controller . '@getUpdateStatusData')->name('update_status_data')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::get('/search', $controller . '@search')->name('search');
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
    });

    Route::prefix('event_session')->name('event_session.')->group(function(){
        $controller = 'EventSessionController';
        $moduleName = 'event_session';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);;
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/update-status', $controller . '@getUpdateStatusData')->name('update_session_status_data')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::post('{session}/delete-attendees/{person}', $controller . '@destroyAttendees')->name('deleteAttendees')->middleware(['permission:'.getPermissionKey($moduleName, 'delete_attendees', false)]);;

        Route::post('{session}/add-attends', $controller . '@addAttends')->name('add_attends');
        Route::get('{session}/get-attends', $controller . '@getAttends')->name('get_attends');

    });

    Route::prefix('event_session_attempt')->name('event_session_attempt.')->group(function(){
        $controller = 'EventSessionAttemptController';
        $moduleName = 'event_session_attempt';
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);;
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store/{attempt}', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
    });

    Route::prefix('session_request')->name('session_request.')->group(function(){
        $controller = 'EventSessionRequestController';
        $moduleName = 'session_request';
        Route::get('search', $controller . '@search')->name('search');
        Route::get('', $controller . '@index')->name('index')->middleware(['permission:'.getPermissionKey($moduleName, 'index', true)]);
        Route::get('/show/{id?}', $controller . '@show')->name('show')->middleware(['permission:'.getPermissionKey($moduleName, 'show', false)]);;
        Route::get('/create', $controller . '@create')->name('create')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::post('/create-data', $controller . '@createData')->name('create_data')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/edit/{id?}', $controller . '@edit')->name('edit')->middleware(['permission:'.getPermissionKey($moduleName, 'update', true)]);;
        Route::post('/store', $controller . '@store')->name('store')->middleware(['permission:'.getPermissionKey($moduleName, 'create', true)]);
        Route::get('/update-status', $controller . '@getUpdateStatusData')->name('update_session_request_status_data')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::post('/update-status', $controller . '@updateStatus')->name('update_status')->middleware(['permission:'.getPermissionKey($moduleName, 'status_update', false)]);;
        Route::post('/delete', $controller . '@destroy')->name('delete')->middleware(['permission:'.getPermissionKey($moduleName, 'delete', true)]);;
    });
});
