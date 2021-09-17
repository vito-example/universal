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

use App\Modules\Customer\Auth\Http\Controllers\AuthenticatedSessionController;
use App\Modules\Customer\Auth\Http\Controllers\CustomerEmailVerifyController;
use App\Modules\Customer\Auth\Http\Controllers\CustomerFinishProfileController;
use App\Modules\Customer\Auth\Http\Controllers\CustomerVerificationNotificationController;
use App\Modules\Customer\Auth\Http\Controllers\CustomerVerificationPromptController;
use App\Modules\Customer\Auth\Http\Controllers\CustomerVerifyController;
use App\Modules\Customer\Auth\Http\Controllers\NewPasswordController;
use App\Modules\Customer\Auth\Http\Controllers\PasswordController;
use App\Modules\Customer\Auth\Http\Controllers\PasswordResetLinkController;
use App\Modules\Customer\Auth\Http\Controllers\RegisteredUserController;
use App\Modules\Customer\Auth\Http\Controllers\SocialController;
use App\Modules\Customer\Http\Controllers\Web\Client\ProfileInformationController;
use App\Modules\Customer\Http\Controllers\Web\Client\UserProfileController;
use App\Modules\Customer\Http\Controllers\Web\Client\UserStatusController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware(['guest:sanctum'])
        ->name('password.request');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware(['guest:sanctum'])
        ->name('password.reset');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest:sanctum'])
        ->name('password.phone');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['guest:sanctum'])
        ->name('password.update');

    $limiter = config('fortify.limiters.login');
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest:sanctum'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:sanctum',
            $limiter ? 'throttle:'.$limiter : null,
        ]));

    // Social auth
    Route::get('login/{provider}', [SocialController::class, 'socialRedirect'])
        ->middleware(['guest:sanctum'])
        ->name('login.social');

    Route::get('login/social/callback/{provider}', [SocialController::class, 'loginWithSocial']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware(['guest:sanctum'])
        ->name('register');

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:sanctum']);

    Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
        ->middleware(['auth','verified'])
        ->name('user-profile-information.update');

    Route::put('/user/password', [PasswordController::class, 'update'])
        ->middleware(['auth'])
        ->name('user-password.update');
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])
            ->name('logout');
    });

    Route::middleware(['auth:sanctum','verified'])->group(function(){
        Route::get('/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::get('/profile/companies', [UserProfileController::class, 'companies'])
            ->name('profile.companies');
        Route::get('/profile/colleagues', [UserProfileController::class, 'colleagues'])
            ->name('profile.colleagues');
        Route::get('/profile/security', [UserProfileController::class, 'security'])
            ->name('profile.security');
        Route::get('/profile/trainings', [UserProfileController::class, 'trainings'])
            ->name('profile.trainings');

        Route::post('/profile/email/verify-create', [CustomerEmailVerifyController::class,'create'])->middleware('auth')->name('verify.email.create');
        Route::post('/profile/email/verify-store', [CustomerEmailVerifyController::class,'store'])->middleware('auth')->name('verify.email.store');
        Route::post('/profile/email/verify-resend', [CustomerEmailVerifyController::class,'resendVerify'])->middleware('auth')->name('verify.email.resend');
    });

    Route::middleware('not_verified')->group(function(){
        Route::get('/customer/finish-profile', [CustomerFinishProfileController::class, 'create'])
            ->name('profile.finish');

        Route::post('/customer/finish-profile', [CustomerFinishProfileController::class, 'store'])
            ->name('profile.finish');

        Route::get('/customer/verify', [CustomerVerificationPromptController::class, '__invoke'])
            ->name('verification.notice');

        Route::post('/customer/verify', [CustomerVerifyController::class, '__invoke'])
            ->middleware(['throttle:6,1'])
            ->name('verification.verify');

        Route::post('/customer/verification-notification', [CustomerVerificationNotificationController::class, 'store'])
            ->middleware(['auth', 'throttle:6,1'])
            ->name('verification.send');
    });
});
