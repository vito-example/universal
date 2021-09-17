<?php


namespace App\Modules\Customer\Http\Controllers\Web\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserStatusController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function showDisable(Request $request)
    {
        return Jetstream::inertia()->render($request, 'User/Disable');
    }

}
