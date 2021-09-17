<?php


namespace App\Modules\Customer\Http\Resources\Customer;


use App\Models\User;
use App\Modules\Event\Models\Event;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property User customer
 */
class CustomerResource
{

    /**
     * @var User
     */
    protected User $customer;

    /**
     * CustomerProfileResource constructor.
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
    public function toAdminProfile(): array
    {
        return array_merge($this->personalData(),[
            'companies' => $this->customer->ownCompanies
        ]);
    }

    /**
     * @return array
     */
    public function toProfile(): array
    {
        return array_merge($this->personalData(),[]);
    }

    /**
     * @return array
     */
    private function personalData(): array
    {
        return [
            'id'    => $this->customer->id,
            'name'  => $this->customer->name,
            'surname' => $this->customer->surname,
            'email' => $this->customer->email,
            'phone_number' => $this->customer->phone_number,
            'profile_photo_url' => $this->customer->profile_photo_path ? $this->customer->profile_photo_url : null
        ];
    }

    /**
     * @return Event[]|Collection|\Illuminate\Support\Collection|mixed
     */
    private function registeredEvents()
    {
        return $this->customer->events->sortByDesc('start_date')->map(function(Event $event){
            return [
                'id'    => $event->id,
                'title' => $event->title,
                'start_date'    => $event->start_date->format('Y-m-d H:i:s')
            ];
        });
    }

}
