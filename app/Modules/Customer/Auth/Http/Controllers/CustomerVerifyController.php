<?php

namespace App\Modules\Customer\Auth\Http\Controllers;

use App\Modules\Customer\Auth\Http\Requests\VerifyCustomerRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;

class CustomerVerifyController extends Controller
{
    /**
     * @param VerifyCustomerRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(VerifyCustomerRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->intended(route('home.index',['verified' => 1]));
        }

        if ($request->user()->markPhoneAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('home.index',['verified' => 1]));
    }
}
