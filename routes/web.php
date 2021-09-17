<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get(config('cms.front.coming_soon_prefix'),function(){
    return view('coming');
});

Route::middleware(['auth:sanctum', 'verified','language'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/fire', function () {
    event(new \App\Events\TestEvent());
    return 'ok';
});
