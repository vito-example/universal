<?php


namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Modules\Customer\Auth\Http\Requests\UpdatesUserPasswordsRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class PasswordController
{

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
     * @param UpdatesUserPasswordsRequest $request
     * @param UpdatesUserPasswords $updater
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdatesUserPasswordsRequest $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'password-updated');
    }

}
