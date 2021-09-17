<?php


namespace App\Modules\Event\Http\Resources\Event;


use App\Modules\Event\Models\Event;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;
use SeoData;

/**
 * @property  resource
 */
class EventListResource
{

    /**
     * @var
     */
    protected $resource;

    /**
     * EventListResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @param null $request
     *
     * @return array|void
     */
    public function toPaginate($request = null)
    {
        /** @var $eventsPaginator LengthAwarePaginator */
        $eventsPaginator = $this->resource;
        $eventItems = [];

        /** @var $event Event */
        foreach ($eventsPaginator->getIterator() as $event) {
            $eventItems[] = (new EventItemResource($event))->toListItem();
        }

        $eventsPaginator->setCollection(collect($eventItems));

        return $eventsPaginator->toArray();
    }

    /**
     * @param int $qty
     * @return array
     */
    public function toTake($qty = 5) {
        $eventItems = $this->resource->take($qty)->get();
        $items = [];

        foreach ($eventItems as $event) {
            $items[] = (new EventItemResource($event))->toListItem();
        }

        return $items;
    }

    /**
     * @return array
     */
    public function toSeoData()
    {
        return SeoData::setTitle(__('seo.event.title'))
            ->setDescription( __('seo.event.description'))
            ->setKeywords( __('seo.event.description'))
            ->setOgTitle( __('seo.event.title'))
            ->setOgDescription( __('seo.event.description'))
            ->getSeoData();
    }

}
