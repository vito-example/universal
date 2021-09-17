<?php

namespace App\Modules\Landing\Http\Controllers\Client;

use App\Modules\Event\Http\Resources\Event\EventListResource;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Services\Event\EventData;
use App\Modules\Landing\Http\Resources\Blog\BlogItemResource;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Blog;
use App\Modules\Pages\Models\Page;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Jetstream\Jetstream;
use Meta;
use PageSeoService;
use SeoData;
use View;

/**
 * @property MetaInterface meta
 */
class PreviewPageController extends Controller
{

    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * LandingPageController constructor.
     *
     * @param MetaInterface $meta
     */
    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function home(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Home/Index');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function register(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Customer/Register');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainings(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Trainings/Index');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainingsView(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Trainings/Show');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainers(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Trainers/Index');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function news(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/News/Index');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function newsView(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/News/Show');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function about(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/About/Index');
    }


    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainingRegister(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Trainings/Register');
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function profile(Request $request)
    {
        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription( __('seo.home.description'))
            ->setKeywords( __('seo.home.description'))
            ->setOgTitle( __('seo.home.title'))
            ->setOgDescription( __('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Preview/Profile/Index');
    }
}
