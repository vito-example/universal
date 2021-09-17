<?php


namespace App\Channels;

use SmsGateway;
use Illuminate\Notifications\Notification;
use Log;

class SmsChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $response = SmsGateway::sendSms('995'.$message['number'],$message['message']);
        if (!$response->getResponse()['status']) {
            Log::error('[Error Sms Gateway]',[
                'error' => $response
            ]);
        }

    }
}
