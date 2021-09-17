<?php


namespace App\Modules\Customer\Auth\Traits;


use App\Modules\Customer\Auth\Notifications\VerifyPhone;
use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyPhone
{

    /**
     * Determine if the user has verified their phone address.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ! is_null($this->verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'verified_at' => $this->freshTimestamp(),
            'remember_token'    => null
        ])->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification()
    {
        $this->forceFill([
            'remember_token' => mt_rand(1000,9999),
        ])->save();
        $this->notify(new VerifyPhone);
    }

    /**
     * Get the phone that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phone_number;
    }

}
