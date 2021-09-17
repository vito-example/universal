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

use App\Modules\Landing\Http\Controllers\Client\LandingPageController;
use App\Modules\Landing\Http\Controllers\Client\PreviewPageController;
use Illuminate\Support\Facades\Route;
    Route::redirect('','admin')->name('home.index');

Route::get('language/{language}', function ($language) {
    $fullUrlWithoutDomain = Str::replaceFirst(config('app.url'),'',url()->previous());
    $fullUrlWithoutDomain = Str::replaceFirst(app()->getLocale(),$language,$fullUrlWithoutDomain);
    app()->setLocale($language);
    return redirect()->intended($fullUrlWithoutDomain);
})->name('language');

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::get('',[LandingPageController::class,'home'])->name('home.index');
    Route::get('about',[LandingPageController::class,'about'])->name('about.index');
    Route::get('contact',[LandingPageController::class,'contact'])->name('contact.index');
    Route::post('/contact', [LandingPageController::class, 'contactSend'])->name('contact.send');

    Route::prefix('news')->group(function () {
        Route::get('',[LandingPageController::class, 'news'])->name('news.index');
        Route::get('{slug}',[LandingPageController::class, 'newsView'])->name('news.show');
    });

    Route::prefix('trainers')->group(function () {
        Route::get('',[LandingPageController::class, 'trainers'])->name('trainers.index');
        Route::get('/{slug}',[LandingPageController::class, 'trainersShow'])->name('trainers.show');
    });

    Route::prefix('preview')->group(function () {
        Route::get('',[PreviewPageController::class, 'home'])->name('preview.home');

        Route::prefix('register')->group(function () {
            Route::get('',[PreviewPageController::class, 'register'])->name('preview.register');
        });

        Route::prefix('trainings')->group(function () {
            Route::get('',[PreviewPageController::class, 'trainings'])->name('preview.trainings');
            Route::get('online',[PreviewPageController::class, 'trainings'])->name('preview.online');
            Route::get('show',[PreviewPageController::class, 'trainingsView'])->name('preview.trainings.show');
            Route::get('show/{register}',[PreviewPageController::class, 'trainingRegister'])->name('preview.trainings.register');
        });

        Route::prefix('trainers')->group(function () {
            Route::get('',[PreviewPageController::class, 'trainers'])->name('preview.trainers');
        });

        Route::prefix('news')->group(function () {
            Route::get('',[PreviewPageController::class, 'news'])->name('preview.news');
            Route::get('show',[PreviewPageController::class, 'newsView'])->name('preview.news.show');
        });

        Route::get('about',[PreviewPageController::class,'about'])->name('preview.about');

        Route::prefix('profile')->group(function () {
            Route::get('',[PreviewPageController::class, 'profile'])->name('preview.profile');
        });
    });

});
