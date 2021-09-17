<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Page;
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

        Jetstream::deleteUsersUsing(DeleteUser::class);

        $layoutData = null;
        $betaModalResponseData = null;
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

            $pages = Page::whereIn('name', [ Page::NAME_SOCIAL])->get();
            $layoutData = [];
            foreach($pages as $page) {
                $pageData = (new PageMetaInfoResource($page->meta))->toArray();
                $layoutData[$page->name] =!empty($pageData[0]) ? $pageData[0] : [];
            }
        }

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
                $file = resource_path('lang/' . app()->getLocale() . '.json');
                if (!file_exists($file)) {
                    return [];
                } else {
                    return json_decode(file_get_contents($file), true);
                }
            },
            'loginModal' => function () {
                return Session::get('loginModal')
                    ? Session::get('loginModal')
                    : false;
            },
            'verifyModal' => function () {
                return Session::get('verifyModal')
                    ? Session::get('verifyModal')
                    : false;
            },
            'finishProfileModal' => function () {
                return Session::get('finishProfileModal')
                    ? Session::get('finishProfileModal')
                    : false;
            },
            'emailVerifyModal' => function () {
                return Session::get('emailVerifyModal')
                    ? Session::get('emailVerifyModal')
                    : false;
            },
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
