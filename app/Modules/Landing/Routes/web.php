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

    Route::prefix('blog')->group(function () {
        Route::get('',[LandingPageController::class, 'blog'])->name('blog.index');
        Route::get('{slug}',[LandingPageController::class, 'blogView'])->name('blog.show');
    });

    Route::prefix('project')->group(function () {
        Route::get('',[LandingPageController::class, 'project'])->name('project.index');
        Route::get('{slug}',[LandingPageController::class, 'projectView'])->name('project.show');
    });
});
