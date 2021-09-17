<?php


namespace App\Modules\Event\Http\Resources\Calendar;


use App\Models\User;
use App\Modules\Event\Http\Resources\Event\EventItemResource;
use App\Modules\Event\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCalendarResource extends JsonResource
{

    /**
     * CustomerCalendarResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var $customer User */
        $customer = $this->resource;
        $calendarData = [];
        $startDate = Carbon::parse($request->get('start_date'))->addDay();
        $endDate = Carbon::parse($request->get('end_date'));

        $customerEvents = Event::with([
            'translations',
            'images',
            'eventLanguage'
        ])->filter([
            'attendees_id'  => $customer ? [$customer->id] : null,
            'start_date_from' => $startDate->format('Y-m-d'),
            'start_date_to'  => $endDate->format('Y-m-d')
        ])->get();

        /** @var $event Event */
        foreach($customerEvents as $event) {
            $eventItem = (new EventItemResource($event))->toCalendarItem();
            $calendarData[] = [
                'id'    => $event->id,
                'startDate' => $eventItem['start_date'],
                'title' => $eventItem['title'],
                'url'   => $eventItem['conference_url'],
                'customData'    => $eventItem
            ];
        }

        return $calendarData;
    }

}
