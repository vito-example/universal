<?php


namespace App\Modules\Customer\Http\Controllers\Web\Client;


use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeItemResource;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Customer\Http\Resources\Customer\CustomerResource;
use Illuminate\Http\Request;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;
use SeoData;
use View;

class UserProfileController extends \Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController
{

    /**
     * Show the general profile settings screen.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function show(Request $request): Response
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

        $user = auth()->user();
        $companies = $user->companies ? $user->companies->map(function ($company) {
            return (new CompanyItemResource($company))->toProfile();
        }) : [];

        $tab = $request->get('tab') ?? 'trainings';
        return Jetstream::inertia()->render($request, 'Landing/Profile/Index',[
            'user' => (new CustomerItemResource($user))->toProfile(),
            'companies' => $companies,
            'trainings' => $user->trainings(),
            'tab' => $tab
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
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

        $user = auth()->user();

        return Jetstream::inertia()->render($request, 'Landing/Profile/Edit',[
            'user' => (new CustomerItemResource($user))->toProfile()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function security(Request $request): Response
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

        $user = auth()->user();

        return Jetstream::inertia()->render($request, 'Landing/Profile/Security',[
            'user' => (new CustomerItemResource($user))->toProfile()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function companies(Request $request): Response
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

        $user = auth()->user();
        $companies = $user->companies ? $user->companies->map(function ($company) {
            return (new CompanyItemResource($company))->toProfile();
        }) : [];

        return Jetstream::inertia()->render($request, 'Landing/Profile/Companies',[
            'user' => (new CustomerItemResource($user))->toProfile(),
            'companies' => $companies
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function colleagues(Request $request): Response
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

        $user = auth()->user();
        $companies = $user->companies ? $user->companies->map(function ($company) {
            return (new CompanyItemResource($company))->toProfile();
        }) : [];

        return Jetstream::inertia()->render($request, 'Landing/Profile/Colleagues',[
            'user' => (new CustomerItemResource($user))->toProfile(),
            'companies' => $companies
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function trainings(Request $request): Response
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

        $user = auth()->user();

        return Jetstream::inertia()->render($request, 'Landing/Profile/Trainings',[
            'user' => (new CustomerItemResource($user))->toProfile(),
            'trainings' => $user->trainings(),
        ]);
    }

}
