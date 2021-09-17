<?php

namespace App\Modules\Base\Providers;

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
        $this->loadTranslationsFrom(module_path('base', 'Resources/Lang', 'app'), 'base');
        $this->loadViewsFrom(module_path('base', 'Resources/Views', 'app'), 'base');
        $this->loadMigrationsFrom(module_path('base', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('base', 'Config', 'app'));
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
        $this->app->register(BaseModuleServiceProvider::class);
    }
}
