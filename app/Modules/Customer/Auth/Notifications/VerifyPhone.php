<?php

namespace App\Modules\Customer\Auth\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class VerifyPhone extends Notification
{

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * @param $notifiable
     *
     * @return array
     */
    public function toSms($notifiable)
    {
        return [
            'number'    => $notifiable->phone_number,
            'message'   => __('Your Verify code is') . ' ' . $notifiable->remember_token
        ];
    }

}
