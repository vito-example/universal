<?php

namespace App\Modules\Pages\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Modules\Pages\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the module.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the module.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $locale = request()->segment(1);
        $prefix = '';
        if(in_array($locale, config('language_manager.locales')) ) {
            app()->setLocale($locale);
            $prefix = $locale;
        }

        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
            'prefix'    =>   $prefix . '/' . config('cms.front.landing_prefix')
        ], function ($router) {
            require module_path('pages', 'Routes/web.php', 'app');
        });
    }

    /**
     * Define the "web" routes for the module.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web','auth:admin'],
            'namespace'  => $this->namespace . '\Admin',
            'prefix'     => config('cms.admin.prefix') . '/' . config('cms.admin.version')
        ], function ($router) {
            require module_path('pages', 'Routes/admin.php', 'app');
        });
    }

    /**
     * Define the "api" routes for the module.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'auth:api',
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
        ], function ($router) {
            require module_path('pages', 'Routes/api.php', 'app');
        });
    }

}
