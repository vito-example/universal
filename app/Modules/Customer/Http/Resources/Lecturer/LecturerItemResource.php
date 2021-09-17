<?php
/**
 *  app\Modules\Customer\Http\Resources\Lecturer\LecturerItemResource.php
 *
 * Date-Time: 7/14/2021
 * Time: 8:43 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Customer\Http\Resources\Lecturer;


use App\Modules\Customer\Models\Lecturer;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class LecturerItemResource
 * @package App\Modules\Customer\Http\Resources\Lecturer
 */
class LecturerItemResource implements Arrayable
{
    /**
     * @var Lecturer
     */
    protected Lecturer $resource;

    /**
     * LecturerItemResource constructor.
     * @param Lecturer $lecturer
     */
    public function __construct(Lecturer $lecturer)
    {
        $this->resource = $lecturer;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->resource->full_name .  " ({$this->resource->id})",
            'image_url' => $this->resource->getImageByKey('profile')
        ];
    }
}
