<?php


namespace App\Modules\Customer\Http\Resources\Activity;


use App\Modules\Customer\Models\Activity;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection|array resource
 */
class ActivityListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * ActivityListResource constructor.
     *
     * @param null $resource
     */
    public function __construct($resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->resource->map(function(Activity $activity){
            return (new ActivityItemResource($activity))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources()
    {
        $this->resource = Activity::with([
            'translations'
        ])->active()->get();
        return $this;
    }

}
