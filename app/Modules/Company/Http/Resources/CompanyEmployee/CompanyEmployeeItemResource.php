<?php
/**
 *  app\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeItemResource.php
 *
 * Date-Time: 8/15/2021
 * Time: 11:00 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Company\Http\Resources\CompanyEmployee;

use App\Modules\Company\Models\CompanyEmployee;

/**
 * Class CompanyEmployeeItemResource
 * @package App\Modules\Company\Http\Resources\CompanyEmployee
 */
class CompanyEmployeeItemResource
{

    /**
     * @var CompanyEmployee|null
     */
    protected ?CompanyEmployee $resource;

    /**
     * CompanyEmployeeEditItemResource constructor.
     *
     * @param CompanyEmployee|null $resource
     */
    public function __construct(CompanyEmployee $resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        /** @var $item CompanyEmployee */
        $item = $this->resource;
        $itemData = $item->only(array_merge($item->getFillable(),['id']));
        return $itemData;
    }
}
