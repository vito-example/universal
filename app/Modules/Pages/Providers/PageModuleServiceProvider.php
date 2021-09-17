<?php


namespace App\Modules\Pages\Providers;

use App\Modules\Pages\Services\Admin\PageStore;
use App\Modules\Pages\Services\Client\PageSeoService;
use App\Modules\Pages\Services\Client\SeoData;
use Illuminate\Support\ServiceProvider;

class PageModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register facades services.
     */
    public function register()
    {
        $this->app->bind('PageStore', function(){
            return new PageStore();
        });
        $this->app->bind('PageSeoService',function(){
            return new PageSeoService();
        });
        $this->app->bind('SeoData',function(){
            return new SeoData();
        });
    }

}
