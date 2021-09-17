<?php


namespace App\Modules\Customer\Http\Resources\Citizenship;


use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Citizenship;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @property Citizenship resource
 */
class CitizenshipItemResource implements Arrayable
{
    /**
     * @var Citizenship
     */
    protected $resource;

    /**
     * CitizenshipItemResource constructor.
     *
     * @param Citizenship $citizenship
     */
    public function __construct(Citizenship $citizenship)
    {
        $this->resource = $citizenship;
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
