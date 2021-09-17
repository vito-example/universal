<?php

use App\Modules\Event\Http\Controllers\Api\Client\EventController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::prefix('trainings')->group(function () {
        Route::get('',[EventController::class, 'trainings'])->name('trainings.index');
        Route::get('online',[EventController::class, 'trainingsOnline'])->name('trainings.online');
        Route::get('{slug}',[EventController::class,'trainingsShow'])->name('trainings.show');
    });
    Route::middleware(['auth_customer','finish_profile','verified'])->group(function(){
        Route::prefix('trainings')->group(function () {
            Route::get('{slug}/register',[EventController::class, 'trainingRegisterView'])->name('trainings.register_view');
            Route::post('{slug}/register',[EventController::class, 'trainingRegister'])->name('trainings.register');

            Route::get('{slug}/request',[EventController::class, 'trainingRequestView'])->name('trainings.request_view');
            Route::post('{slug}/request',[EventController::class, 'trainingRequest'])->name('trainings.request');
        });
    });
});
