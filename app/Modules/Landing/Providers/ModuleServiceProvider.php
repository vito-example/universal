<?php

namespace App\Modules\Landing\Providers;

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
        $this->loadTranslationsFrom(module_path('landing', 'Resources/Lang', 'app'), 'landing');
        $this->loadViewsFrom(module_path('landing', 'Resources/Views', 'app'), 'landing');
        $this->loadMigrationsFrom(module_path('landing', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('landing', 'Config', 'app'));
        }
//        $this->loadFactoriesFrom(module_path('landing', 'Database/Factories', 'app'));
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
