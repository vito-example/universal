<?php


namespace App\Modules\Customer\Http\Resources\Activity;


use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\DoctorType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection|array resource
 */
class DoctorTypeListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * DoctorTypeListResource constructor.
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
        return $this->resource->map(function(DoctorType $item){
            return (new DoctorTypeItemResource($item))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources()
    {
        $this->resource = DoctorType::with([
            'translations'
        ])->active()->get();
        return $this;
    }

}
