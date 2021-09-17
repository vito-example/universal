<?php


namespace App\Modules\Event\Http\Resources\Event;


use App\Modules\Event\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

class EventCalendarResource extends JsonResource
{

    /**
     * EventCalendarResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param null $request
     *
     * @return array
     */
    public function toArray($request = null)
    {
        /** @var $item Event */
        $item = $this->resource;
        $conferenceUrl =  route('event.conference_url', generateSlug($item->id,$item->title));
        $description = $item->description;
        $description .= ' \n <a href=' . $conferenceUrl.'>'. $conferenceUrl .'</a>';

        return [
            'title' => $item->title,
            'description'   => $description,
            'start' => $item->start_date ? $item->start_date->format('Y-m-d H:i:s') : '',
            'duration' => [
                1,
                'hour'
            ] // TODO add dybamic duration.
        ];
    }

}
