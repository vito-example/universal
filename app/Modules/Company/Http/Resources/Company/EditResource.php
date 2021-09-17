<?php


namespace App\Modules\Company\Http\Resources\Company;


use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeEditItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyEmployee;
use GetImageWithType;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @property mixed|null resource
 */
class EditResource implements Arrayable
{

    /**
     * @var Company|null
     */
    protected $resource;

    /**
     * EditResource constructor.
     *
     * @param Company|null $resource
     */
    public function __construct(Company $resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @return array|mixed
     */
    public function toArray()
    {
        /** @var $item Company */
        $item = $this->resource;
        $images = GetImageWithType::setImages($item->images->toArray() ?: [])->generateWithType()->getImagesWithType();
        $itemData['main'] = $item->only($item->getFillable());
        $itemData['main']['images'] = $images;
        $itemData['main']['owners'] = $item->ownerMembers->pluck('user_id')->toArray();
        $itemData['employees'] = $item->employees->map(function (CompanyEmployee $companyEmployee) {
            return (new CompanyEmployeeEditItemResource($companyEmployee))->toArray()['main'];
        });
        return $itemData;
    }


}
