<?php
/**
 *  app\Modules\Company\Http\Resources\UserEmployeeItemResource.php
 *
 * Date-Time: 7/25/2021
 * Time: 7:22 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Company\Http\Resources;


use App\Models\User;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Models\Lecturer;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class UserEmployeeItemResource
 * @package App\Modules\Company\Http\Resources
 */
class UserEmployeeItemResource implements Arrayable
{
    /**
     * @var UserEmployeeConnection
     */
    protected UserEmployeeConnection $resource;

    /**
     * UserEmployeeItemResource constructor.
     * @param UserEmployeeConnection $userEmployeeConnection
     */
    public function __construct(UserEmployeeConnection $userEmployeeConnection)
    {
        $this->resource = $userEmployeeConnection;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->getPrefix() . $this->resource->morphable->name .  " ({$this->resource->morphable->id})",
        ];
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        switch (true) {
            case $this->resource->morphable_type === CompanyEmployee::class:
                return 'Em - ';
            case $this->resource->morphable_type === User::class:
                return 'Us - ';
            default:
                return '';
        }
    }
}
