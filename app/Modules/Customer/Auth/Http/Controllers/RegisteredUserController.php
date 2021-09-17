<?php


namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Customer\Auth\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use SeoData;
use View;

class RegisteredUserController extends Controller
{

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterViewResponse
     */
    public function create(Request $request): RegisterViewResponse
    {
        $allSeoData = SeoData::setTitle(__('seo.register.title'))
            ->setDescription( __('seo.register.description'))
            ->setKeywords( __('seo.register.description'))
            ->setOgTitle( __('seo.register.title'))
            ->setOgDescription( __('seo.register.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });
        return app(RegisterViewResponse::class);
    }

    /**
     * @param RegisterRequest $request
     * @param CreatesNewUsers $creator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request,
                          CreatesNewUsers $creator)
    {
        event(new Registered($user = $creator->create($request->all())));
        $this->guard->login($user);

//        return redirect()->route('verification.notice');
        return redirect()->route('home.index');

    }

}
