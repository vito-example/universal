<?php


namespace App\Modules\Customer\Auth\Notifications;


use App\Channels\SmsChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

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
