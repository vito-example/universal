<?php
/**
 *  app\Modules\Event\Http\Resources\Session\SessionItemResource.php
 *
 * Date-Time: 7/17/2021
 * Time: 9:31 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Session;


use App\Models\User;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Models\EventSession;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SessionItemResource
 * @package App\Modules\Event\Http\Resources\Session
 */
class SessionItemResource implements Arrayable
{

    /**
     * @var EventSession
     */
    protected EventSession $eventSession;

    /**
     * SessionItemResource constructor.
     * @param EventSession $eventSession
     */
    public function __construct(EventSession $eventSession)
    {
        $this->eventSession = $eventSession;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'max_person' => $this->eventSession->max_person,
            'price' => $this->eventSession->price,
            'event_id' => $this->eventSession->event_id,
            'start_date' => $this->eventSession->start_date,
            'end_date' => $this->eventSession->end_date,
            'timezone' => $this->eventSession->timezone,
            'status' => $this->eventSession->status,
            'type' => $this->eventSession->type,
            'user_list' => $this->eventSession->userPermissions()->pluck('id'),
            'start_time' => $this->getDateFormat(),
            'link' => $this->eventSession->link
        ];
    }

    /**
     * @return array
     */
    public function toRegister(): array
    {
        return [
            'id' => $this->eventSession->id,
            'max_person' => $this->eventSession->max_person,
            'price' => $this->eventSession->price,
            'event_id' => $this->eventSession->event_id,
            'start_date' => $this->eventSession->start_date,
            'end_date' => $this->eventSession->end_date,
            'timezone' => $this->eventSession->timezone,
            'status' => $this->eventSession->status,
            'type' => $this->eventSession->type,
            'start_time' => $this->getOnlyDateFormat(),
            'start_time_hour' => $this->getOnlyHourFormat($this->eventSession->start_date),
            'can_register' => !($this->eventSession->type === EventSessionTypeOptions::SESSION_TYPE_REQUEST) || in_array(auth()->id(), $this->eventSession->userPermissions()->pluck('id')->toArray()),
            'attendees_user' => $this->eventSession->attendees()->where('morphable_type',User::class)->pluck('morphable_id')->toArray(),
            'attendees_employee' => $this->eventSession->attendees()->where('morphable_type',CompanyEmployee::class)->pluck('morphable_id')->toArray(),
        ];
    }

    /**
     * @param null $employeeIds
     * @return array
     */
    public function toProfile($employeeIds = null): array
    {
        $attendeesEmployee = [];
        $attendeesUser = $this->eventSession->attendees()->where('morphable_type',User::class)->where('morphable_id',auth()->user()->id)->first();
        $attendeesUser = $attendeesUser ? [
            'label' => $attendeesUser->morphable->name,
            'value' => $attendeesUser->morphable_id
        ] : [];

        if ($employeeIds !== null) {
            $persons = $this->eventSession->attendees()->where('morphable_type',CompanyEmployee::class)->whereIn('morphable_id',$employeeIds)->get();
            foreach ($persons as $person) {
                $attendeesEmployee [] = [
                    'label' => $person->morphable->name,
                    'value' => $person->morphable_id
                ];
            }
        }

        return [
            'id' => $this->eventSession->id,
            'price' => $this->eventSession->price,
            'title' => $this->eventSession->event ? $this->eventSession->event->title : '',
            'show_url' => route('trainings.show', generateSlug($this->eventSession->event->id, $this->eventSession->event->title)),
            'place' => $this->eventSession->event->place,
            'form' => $this->eventSession->event->form === EventFormOptions::FORM_ONLINE ? 'online' : 'offline',
            'start_date' => $this->eventSession->start_date,
            'end_date' => $this->eventSession->end_date,
            'timezone' => $this->eventSession->timezone,
            'status' => $this->eventSession->status,
            'type' => $this->eventSession->type,
            'link' => $this->eventSession->link,
            'start_time' => $this->getOnlyDateFormat(),
            'start_time_hour' => $this->getOnlyHourFormat($this->eventSession->start_date),
            'end_time_hour' => $this->getOnlyHourFormat($this->eventSession->end_date),
            'duration' => $this->eventSession->event->duration,
            'can_register' => !($this->eventSession->type === EventSessionTypeOptions::SESSION_TYPE_REQUEST) || in_array(auth()->id(), $this->eventSession->userPermissions()->pluck('id')->toArray()),
            'attendees_employee' => $attendeesEmployee,
            'attendees_user' => [$attendeesUser],
        ];
    }

    /**
     * @return string
     */
    private function getDateFormat()
    {
        if (!$this->eventSession->start_date) {
            return '';
        }
        $startDate = Carbon::parse($this->eventSession->start_date);

        return $startDate->format('Y') . ' ' .
            __('date.month.' .
                $startDate->format('M')) . ' ' . $startDate->format('d') . ' ' .$startDate->format('H:i');
    }

    /**
     * @return string
     */
    private function getOnlyDateFormat()
    {
        if (!$this->eventSession->start_date) {
            return '';
        }
        $startDate = Carbon::parse($this->eventSession->start_date);

        return $startDate->format('Y') . ' ' .
            __('date.month.' .
                $startDate->format('M')) . ' ' . $startDate->format('d');
    }

    /**
     * @return string
     */
    private function getOnlyHourFormat($time)
    {
        if (!$time) {
            return '';
        }

        $date = Carbon::parse($time);

        return $date->format('H:i');
    }

}
