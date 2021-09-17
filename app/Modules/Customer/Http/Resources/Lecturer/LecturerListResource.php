<?php
/**
 *  app\Modules\Customer\Http\Resources\Lecturer\LecturerListResource.php
 *
 * Date-Time: 7/17/2021
 * Time: 10:26 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Http\Resources\Lecturer;


use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Lecturer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LecturerListResource
 * @package App\Modules\Customer\Http\Resources\Lecturer
 */
class LecturerListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * LecturerListResource constructor.
     * @param null $resource
     */
    public function __construct($resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->resource->map(function(Lecturer $lecturer){
            return (new LecturerItemResource($lecturer))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources(): LecturerListResource
    {
        $this->resource = Lecturer::with([
            'translations'
        ])->active()->get();
        return $this;
    }

}
