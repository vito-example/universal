<?php


namespace App\Modules\Company\Http\Resources\CompanyActivity;


use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;

class CompanyActivityItemResource
{

    /**
     * @var Company
     */
    protected $item;

    /**
     * CompanyItemResource constructor.
     *
     * @param CompanyActivity $item
     */
    public function __construct(CompanyActivity $item)
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
            'label' => $this->item->title
        ];
    }


}
