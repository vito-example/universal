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

use App\Modules\Company\Http\Controllers\Web\Client\CompanyController;
use App\Modules\Company\Http\Controllers\Web\Client\CompanyEmployeeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::prefix('company')->name('company.')->middleware('auth_customer')->group(function(){
                Route::get('',[CompanyController::class,'companies'])->name('index');
                Route::get('create',[CompanyController::class,'companyCreate'])->name('create');
                Route::post('store',[CompanyController::class,'companyStore'])->name('store');
                Route::post('destroy/{company}',[CompanyController::class,'companyDestroy'])->name('destroy');
                Route::get('/edit/{slug}',[CompanyController::class,'companyEdit'])->name('edit');
        });

        Route::prefix('employee')->name('employee.')->middleware('auth_customer')->group(function () {
            Route::post('store',[CompanyEmployeeController::class,'companyEmployeeStore'])->name('store');
            Route::post('destroy/{employee}',[CompanyEmployeeController::class,'companyEmployeeDestroy'])->name('destroy');
        });
    });
});
