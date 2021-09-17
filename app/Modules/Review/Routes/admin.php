<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Modules\Review\Http\Controllers\Web\Admin\ReviewController;

Route::name(config('cms.admin.base_route_name') . '.')->group(function(){
    Route::prefix('review')->name('review.')->group(function(){
        Route::get('', [ReviewController::class, 'index'])->name('index');
        Route::post('/update-status', [ReviewController::class, 'updateStatus'])->name('update_status');
    });
});
