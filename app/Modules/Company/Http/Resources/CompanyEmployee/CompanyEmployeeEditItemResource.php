<?php
/**
 *  app/Modules/Company/Http/Resources/CompanyEmployee/CompanyEmployeeEditItemResource.php
 *
 * Date-Time: 22.07.21
 * Time: 14:04
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Company\Http\Resources\CompanyEmployee;

use App\Modules\Company\Models\CompanyEmployee;

/**
 * Class CompanyEmployeeEditItemResource
 * @package App\Modules\Company\Http\Resources\CompanyEmployee
 */
class CompanyEmployeeEditItemResource
{

    /**
     * @var \App\Modules\Company\Models\CompanyEmployee|\App\Modules\Company\Http\Resources\CompanyEmployee\Company|null
     */
    protected ?CompanyEmployee $resource;

    /**
     * CompanyEmployeeEditItemResource constructor.
     *
     * @param \App\Modules\Company\Models\CompanyEmployee|null $resource
     */
    public function __construct(CompanyEmployee $resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @return array|mixed
     */
    public function toArray()
    {
        /** @var $item CompanyEmployee */
        $item = $this->resource;
        $itemData['main'] = $item->only(array_merge($item->getFillable(),['id']));

        return $itemData;
    }
}