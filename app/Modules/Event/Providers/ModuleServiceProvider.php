<?php

namespace App\Modules\Event\Providers;

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
        $this->loadTranslationsFrom(module_path('event', 'Resources/Lang', 'app'), 'event');
        $this->loadViewsFrom(module_path('event', 'Resources/Views', 'app'), 'event');
        $this->loadMigrationsFrom(module_path('event', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('event', 'Config', 'app'));
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
        $this->app->register(EventModuleServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }
}
