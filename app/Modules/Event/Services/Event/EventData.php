<?php

namespace App\Modules\Event\Services\Event;

use App\Modules\Event\Http\Resources\Event\EventListResource;
use App\Modules\Event\Models\Event;

class EventData
{
    /**
     * @var Event
     */
    protected Event $events;

    /**
     * @var array
     */
    protected array $statuses;

    /**
     * @var array
     */
    protected array $filters;

    /**
     * EventData constructor.
     */
    public function __construct()
    {
        $this->events = new Event();
    }

    /**
     * @param array $statuses
     * @return $this
     */
    public function setStatuses(array $statuses = []): EventData
    {
        $this->filters['statuses'] = $statuses;
        return $this;
    }

    /**
     * @param array $forms
     * @return $this
     */
    public function setForms(array $forms = []): EventData
    {
        $this->filters['forms'] = $forms;
        return $this;
    }


    /**
     * @return array
     */
    public function getEvents(): array
    {
        $events = $this->events::with(['translations', 'images'])
            ->filter($this->filters)->orderBy('created_at','DESC');

        return (new EventListResource($events))->toTake(3);
    }
}
