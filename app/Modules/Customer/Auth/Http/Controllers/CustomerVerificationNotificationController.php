<?php

namespace App\Modules\Customer\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Rules\Password;

class CustomerVerificationNotificationController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedPhone()) {
            return $request->wantsJson()
                        ? new JsonResponse('', 204)
                        : redirect()->intended(config('fortify.home'));
        }

        $request->user()->sendPhoneVerificationNotification();

        return redirect()->back()->with('status', \Illuminate\Support\Facades\Password::RESET_LINK_SENT);
    }
}
