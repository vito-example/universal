<?php

namespace App\Providers;

use App\Modules\Pages\Models\Page;
use Illuminate\Support\ServiceProvider;
use PageSeoService;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
