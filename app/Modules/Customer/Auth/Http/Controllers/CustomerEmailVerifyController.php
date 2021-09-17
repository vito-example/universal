<?php
/**
 *  app\Modules\Customer\Auth\Http\Controllers\CustomerEmailVerifyController.php
 *
 * Date-Time: 9/16/2021
 * Time: 5:57 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Models\User;
use App\Modules\Customer\Auth\Http\Requests\VerifyCustomerRequest;
use App\Modules\Landing\Mail\VerifySend;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mail;

class CustomerEmailVerifyController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        return $this->sendNotify($user)
            ? redirect()->back()->with(['emailVerifyModal' => true])
            : redirect()->intended(route('home.index'));
    }

    /**
     * @param VerifyCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(VerifyCustomerRequest $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect(route('profile.edit'));
    }

    /**
     * @return RedirectResponse
     */
    public function resendVerify(): RedirectResponse
    {
        $user = User::find(auth()->user()->id);

        return $this->sendNotify($user)
            ? redirect()->back()->with(['emailVerifyModal' => true])
            : redirect()->intended(route('home.index'));
    }

    /**
     * @param User $user
     * @return bool
     */
    public function sendNotify(User $user): bool
    {
        $user->forceFill([
            'remember_token' => mt_rand(1000, 9999),
        ])->save();

        $data = [
            'name' => $user->full_name,
            'code' => $user->remember_token
        ];

        $data ['to'] = $user->email;
        $data ['subject'] = __('აგრარიუმი - ელ-ფოსტის ვერიფიკაცია.');

        Mail::to($data['to'])->send(new VerifySend($data));

        return true;
    }
}

