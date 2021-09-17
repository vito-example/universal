<?php


namespace App\Modules\Customer\Http\Controllers\Web\Client;


use App\Modules\Customer\Auth\Interfaces\MustVerifyPhone;
use App\Modules\Customer\Http\Requests\Client\ProfileUpdateRequest;
use Arr;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Redirect;

class ProfileInformationController extends Controller
{

    /**
     * @param ProfileUpdateRequest $request
     * @param UpdatesUserProfileInformation $updater
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ProfileUpdateRequest $request,UpdatesUserProfileInformation $updater)
    {
        $status = $this->updateUser($request->user(), $request->all());

//        if ($status == 'update-profile-and-phone') {
//            return Redirect::route('verification.notice');
//        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'profile-information-updated');
    }

    /**
     * @param $user
     * @param array $input
     *
     * @return string
     */
    public function updateUser($user, array $input)
    {
        if ($input['phone_number'] !== $user->phone_number &&
            $user instanceof MustVerifyPhone) {
            $isNewPhone = true;
            $status = 'update-profile-and-phone';
        } else {
            $isNewPhone = false;
            $status = 'update-profile';
        }

        $user->forceFill($input)->save();

        if ($isNewPhone) {
            $this->updateVerifiedUser($user);
        }
        return $status;
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function updateVerifiedUser($user)
    {
        $user->forceFill([
            'verified_at' => null,
        ])->save();

        $user->sendPhoneVerificationNotification();
    }

}
