<?php

namespace App\Modules\Pages\Http\Controllers\Api\Client;

use App\Modules\Pages\Http\Requests\Client\SubscribeRequest;
use App\Modules\Pages\Http\Requests\Client\UnSubscribeRequest;
use App\Modules\Pages\Models\Subscriber;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{

    /**
     * @param SubscribeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(SubscribeRequest $request)
    {
        Subscriber::create([
            'email'             => $request->get('email'),
            'name'              => $request->get('first_name'),
            'last_name'         => $request->get('last_name'),
            'is_subscribed'     => Subscriber::SUBSCRIBED_YES
        ]);

        return response()->json([
            'message'   => __('client.subscriber.subscribed_successfully')
        ]);
    }

    /**
     * @param UnSubscribeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable(UnSubscribeRequest $request)
    {
        Subscriber::where('email',$request->get('email'))->update([
            'is_subscribed'     => Subscriber::SUBSCRIBED_NO
        ]);

        return response()->json([
            'message'   => __('client.subscriber.unsubscribed_successfully')
        ]);
    }


}
