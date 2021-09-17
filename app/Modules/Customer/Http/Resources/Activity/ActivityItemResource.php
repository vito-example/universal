<?php


namespace App\Modules\Customer\Http\Resources\Activity;


use App\Modules\Customer\Models\Activity;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @property Activity resource
 */
class ActivityItemResource implements Arrayable
{
    /**
     * @var Activity
     */
    protected $resource;

    /**
     * ActivityItemResource constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->resource = $activity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value'     => $this->resource->id,
            'label'     => $this->resource->title
        ];
    }
}
