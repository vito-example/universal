<?php


namespace App\Modules\Customer\Http\Resources\Activity;


use App\Modules\Customer\Models\DoctorType;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @property DoctorType resource
 */
class DoctorTypeItemResource implements Arrayable
{
    /**
     * @var DoctorType
     */
    protected $resource;

    /**
     * DoctorTypeItemResource constructor.
     *
     * @param DoctorType $resource
     */
    public function __construct(DoctorType $resource)
    {
        $this->resource = $resource;
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
