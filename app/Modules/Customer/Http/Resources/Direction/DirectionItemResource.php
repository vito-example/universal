<?php
/**
 *  app/Modules/Customer/Http/Resources/Direction/DirectionItemResource.php
 *
 * Date-Time: 07.07.21
 * Time: 13:53
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Http\Resources\Direction;


use App\Modules\Customer\Models\Direction;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class DirectionItemResource
 * @package App\Modules\Customer\Http\Resources\Direction
 */
class DirectionItemResource implements Arrayable
{
    /**
     * @var \App\Modules\Customer\Models\Direction
     */
    protected $resource;
    protected $lastChild;
    protected $recursive;

    /**
     * DirectionItemResource constructor.
     *
     * @param \App\Modules\Customer\Models\Direction $direction
     * @param bool $lastChild
     */
    public function __construct(Direction $direction, bool $recursive = false, bool $lastChild = false)
    {
        $this->resource = $direction;
        $this->lastChild = $lastChild;
        $this->recursive = $recursive;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'id' => $this->resource->id,
            'label' => $this->resource->title,
            'children' => []
        ];

        if (!$this->recursive) {
            return $data;
        }

        if (!$this->lastChild) {
            $data['children'] = $this->resource->level === 1 ? (new DirectionListResource($this->resource->childDirections()->get()))->toArray() : [];
            return $data;
        }

        if ($this->resource->childDirections){
            foreach ($this->resource->childDirections as $child) {
                $data['children'][] = (new DirectionItemResource($child, true,true))->toArray();
            }
        }
        return $data;
    }


    /**
     * @return array
     */
    public function toQuery(): array
    {
        return [
            'id' => $this->resource->id,
            'label' => $this->resource->title,
            'parents' => $this->resource->parents ? $this->resource->parents->map(function ($direction) {
                return (new DirectionItemResource($direction))->toQuery();
            })->toArray() : [] ,
            'offlineRoute' => route('trainings.index',['directions[]' => $this->resource->id]),
            'onlineRoute' => route('trainings.online',['directions[]' => $this->resource->id])
        ];
    }
}
