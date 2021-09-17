<?php


namespace App\Modules\Customer\Http\Resources\Customer;


use App\Models\User;

class CustomerItemResource
{

    /**
     * @var User
     */
    protected $customer;

    /**
     * CustomerItemResource constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->customer = $user;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value' => $this->customer->id,
            'label' => $this->customer->name . ' ' . $this->customer->surname . " {$this->customer->id}",
            'image_url' => $this->customer->profile_photo_url
        ];
    }

    /**
     * @return array
     */
    public function toProfile(): array
    {
        return [
            'name' => $this->customer->name,
            'surname' => $this->customer->surname,
            'email' => $this->customer->email,
            'email_verify' => $this->customer->email_verified_at ?? false,
            'phone_number' => $this->customer->phone_number
        ];
    }


}
