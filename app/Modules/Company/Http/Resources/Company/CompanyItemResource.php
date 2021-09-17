<?php


namespace App\Modules\Company\Http\Resources\Company;


use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeEditItemResource;
use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyEmployee;

class CompanyItemResource
{

    /**
     * @var Company
     */
    protected $item;

    /**
     * CompanyItemResource constructor.
     *
     * @param Company $item
     */
    public function __construct(Company $item)
    {
        $this->item = $item;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value' => $this->item->id,
            'label' => $this->item->title . " ({$this->item->id})",
            'image_url' => $this->item->getImageByKey('profile')
        ];
    }

    /**
     * @return array
     */
    public function toProfile()
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'address' => $this->item->address,
            'identify_id' => $this->item->identify_id,
            'description' => $this->item->description,
            'employees' => $this->item->employees ? $this->item->employees->map(function (CompanyEmployee $companyEmployee) {
                return (new CompanyEmployeeItemResource($companyEmployee))->toArray();
            }) : []
        ];
    }

    /**
     * @return array
     */
    public function toListItem()
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'description' => $this->item->description,
            'identity_id' => $this->item->identity_id,
            'activities_id' => $this->item->activities->pluck('id')->toArray(),
            'image_url' => $this->item->getImageByKey('profile'),
            'edit_url' => route('company.edit', generateSlug($this->item->id, $this->item->title))
        ];
    }

    /**
     * @return array
     */
    public function toEditItem()
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'identity_id' => $this->item->identity_id,
            'description' => $this->item->description,
            'image_url' => $this->item->getImageByKey('profile'),
            'activities' => $this->item->activities->pluck('id')->toArray()
        ];
    }

    /**
     * @return array
     */
    public function toRegister(): array
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'employees' => $this->item->employees ? $this->item->employees->map(function (CompanyEmployee $employee) {
                return (new CompanyEmployeeItemResource($employee))->toArray();
            }) : []
        ];
    }


}
