<?php


namespace App\Modules\Customer\Http\Resources\Citizenship;


use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Citizenship;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection|array resource
 */
class CitizenshipListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * CitizenshipListResource constructor.
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
        return $this->resource->map(function(Citizenship $citizenship){
            return (new CitizenshipItemResource($citizenship))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources()
    {
        $this->resource = Citizenship::with([
            'translations'
        ])->active()->get();
        return $this;
    }

}
