<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Services\Client\ServiceData;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use PageSeoService;
use Schema;
use Session;
use View;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        $layoutData = null;
        $allSeoData = null;
        if(Schema::hasTable('pages_meta')){
            $analyticSeoData = Page::whereName(Page::NAME_SEO)->first();
            $analytics = PageSeoService::getAnalyticData($analyticSeoData ? $analyticSeoData->first()->meta : []);
            $seoData = PageSeoService::setPath(request()->path())->parsePathAndSetLocale()
                ->parsePathAndSetPageType()->getPageData();
            if ($analytics) {
                $allSeoData = array_merge($analytics, $seoData);
            } else {
                $allSeoData = $seoData;
            }

            View::composer('app', function ($view) use($allSeoData){
                $view->with('allSeoData', $allSeoData);
            });

            $pages = Page::whereIn('name', [ Page::NAME_CONTACT,Page::NAME_SOCIAL])->get();

            $layoutData = [];
            foreach($pages as $page) {
                $pageData = (new PageMetaInfoResource($page->meta))->toArray();
                $layoutData[$page->name] =!empty($pageData[0]) ? $pageData[0] : [];
            }
        }
        $services = (new ServiceData())->getServicesStatic(5);
        Inertia::share([
            'layoutData'   => $layoutData,
            'seo'   => $allSeoData,
            'locale'            => function () {
                return app()->getLocale();
            },
            'available_locales' => function () {
                return config('language_manager.locales');
            },
            'lang'              => function () {
                $file = base_path() . '/lang/'.app()->getLocale().'/client.php';

                if (!file_exists($file)) {
                    return [];
                } else {
                    return include $file;
                }
            },
            'active_route' => 'test',
            'servicesStatic' => $services
        ]);

    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);

    }
}
