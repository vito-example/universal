<?php

namespace App\Modules\Customer\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('customer', 'Resources/Lang', 'app'), 'customer');
        $this->loadViewsFrom(module_path('customer', 'Resources/Views', 'app'), 'customer');
        $this->loadMigrationsFrom(module_path('customer', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('customer', 'Config', 'app'));
        }
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
