<?php
/**
 *  app\Modules\Customer\Auth\Http\Controllers\CustomerFinishProfileController.php
 *
 * Date-Time: 9/16/2021
 * Time: 5:19 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Models\User;
use App\Modules\Customer\Auth\Http\Requests\FinishProfileRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Redirect;

class CustomerFinishProfileController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Application|\Illuminate\Http\RedirectResponse|VerifyEmailViewResponse|mixed
     */
    public function create(Request $request)
    {
        return $request->user() && ($request->user()->email && $request->user()->phone_number)
            ? redirect()->intended(route('home.index'))
            : redirect()->back()->with(['finishProfileModal' => true]);
    }

    /**
     * @param FinishProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FinishProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->updateUser(auth()->user()->id,$request);
        return redirect(route('verification.notice'));
    }

    /**
     * @param int $userId
     * @param FinishProfileRequest $request
     */
    private function updateUser(int $userId, FinishProfileRequest $request) {
        $user = User::find($userId);
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->save();
    }
}

