<?php
/**
 *  app/Modules/Customer/Auth/Http/Controllers/SocialController.php
 *
 * Date-Time: 24.08.21
 * Time: 14:34
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SocialController extends Controller
{

    /**
     * The guard implementation.
     *
     * @var StatefulGuard
     */
    protected StatefulGuard $guard;

    /**
     * Create a new controller instance.
     *
     * @param StatefulGuard $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @param string $provider
     * @return RedirectResponse
     */
    public function socialRedirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function loginWithSocial(string $provider)
    {
        try {

            $user = Socialite::driver($provider)->stateless()->user();

            $user = $this->findOrCreateUser($user, $provider);

            if (null === $user) {
                return redirect()->route('home.index')->with('error','Already exist.');
            }

            $this->guard->login($user);

            return redirect()->route('home.index');

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Finds or creates an user.
     *
     * @param $user
     * @param $provider
     * @return Builder|Model|object|User|null
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->where('provider', $provider)->first();
        if ($authUser) {
            return $authUser;
        }

        $checkUserEmailExist = User::where('email',$user->email)->first();

        if ($checkUserEmailExist) {
            return null;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => encrypt('qweewqewqqwe@www'),
            'provider' => $provider,
            'provider_id' => $user->id,
            'status' => User::STATUS_ACTIVE,
            'terms' => 1
        ]);
    }
}
