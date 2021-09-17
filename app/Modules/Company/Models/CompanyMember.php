<?php

namespace App\Modules\Company\Models;

use App\Models\User;
use App\Modules\Admin\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Company\Models\CompanyMember
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $company_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Company\Models\Company|null $company
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMember whereUserId($value)
 * @mixin \Eloquent
 */
class CompanyMember extends Model
{

    /**
     * Roles.
     */
    const ROLE_OWNER = 'owner';

    /**
     * @var string
     */
    protected $table = 'company_members';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'role'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
