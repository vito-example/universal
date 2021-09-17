<?php


namespace App\Modules\Customer\Auth\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class CustomerVerificationPromptController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|VerifyEmailViewResponse|mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user() && $request->user()->hasVerifiedPhone()
            ? redirect()->intended(route('home.index'))
            : redirect()->back()->with(['verifyModal' => true]);
    }
}

