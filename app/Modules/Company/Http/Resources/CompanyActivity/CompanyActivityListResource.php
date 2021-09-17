<?php


namespace App\Modules\Company\Http\Resources\CompanyActivity;


use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\DoctorType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection|array resource
 */
class CompanyActivityListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * CompanyActivityListResource constructor.
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
        return $this->resource->map(function(CompanyActivity $item){
            return (new CompanyActivityItemResource($item))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources()
    {
        $this->resource = CompanyActivity::with([
            'translations'
        ])->active()->get();
        return $this;
    }

}
