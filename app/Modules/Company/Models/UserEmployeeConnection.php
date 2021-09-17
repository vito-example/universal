<?php
/**
 *  app\Modules\Company\Models\UserEmployeeConnection.php
 *
 * Date-Time: 7/25/2021
 * Time: 11:24 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Company\Models;


use App\Models\User;
use App\Modules\Admin\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class UserEmployeeConnection
 * @package App\Modules\Company\Models
 * @property int $id
 * @property string $morphable_type
 * @property int $morphable_id
 * @property string|null $type
 */
class UserEmployeeConnection extends BaseModel
{

    /**
     * @var string
     */
    protected $table = 'users_employees_connections';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the parent morphable model (User or CompanyEmployee).
     */
    public function morphable()
    {
        return $this->morphTo();
    }

}
