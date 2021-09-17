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
use App\Modules\Review\Http\Controllers\Api\Client\ReviewController;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::prefix('review')->group(function () {
        Route::post('store',[ReviewController::class, 'store'])->name('review.store');
    });
});
