<?php
/**
 *  app/Modules/Customer/Http/Resources/Direction/DirectionListResource.php
 *
 * Date-Time: 07.07.21
 * Time: 13:55
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Http\Resources\Direction;


use App\Modules\Customer\Models\Direction;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DirectionListResource
 * @package App\Modules\Customer\Http\Resources\Direction
 */
class DirectionListResource implements Arrayable
{

    /**
     * @var Collection|array
     */
    protected $resource;

    /**
     * @var bool
     */
    protected $recursive;
    protected $lastChild;

    /**
     * DirectionListResource constructor.
     *
     * @param null $resource
     */
    public function __construct($resource = null, bool $recursive = false, bool $lastChild = false)
    {
        $this->resource = $resource;
        $this->recursive = $recursive;
        $this->lastChild = $lastChild;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->resource->map(function (Direction $direction) {
            return (new DirectionItemResource($direction, $this->recursive, $this->lastChild))->toArray();
        })->toArray();
    }

    /**
     * @return $this
     */
    public function getAndSetAllResources(): DirectionListResource
    {
        $this->resource = Direction::with([
            'translations'
        ])->active()->get();
        return $this;
    }

    /**
     * @return $this
     */
    public function getAndSetCrudResources(int $id = 0, bool $recursive = false, bool $lastChild = false): DirectionListResource
    {
        $this->resource = Direction::with([
            'translations',
            'childDirections'
        ])
            ->where('id', '!=', $id)
            ->whereNull('parent_id')
            ->active()
            ->get();
        $this->recursive = $recursive;
        $this->lastChild = $lastChild;

        return $this;
    }
}
