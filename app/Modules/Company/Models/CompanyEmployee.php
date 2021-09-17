<?php
/**
 *  app/Modules/Company/Models/CompanyEmployee.php
 *
 * Date-Time: 22.07.21
 * Time: 09:14
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Company\Models;

use App\Modules\Company\Http\Resources\CompanyEmployee\UserEmployeeTypeOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Company\Models\CompanyEmployee
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $role
 * @property string|null $specialty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Company\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @method static Builder|CompanyActivity listsTranslations(string $translationField)
 * @method static Builder|CompanyActivity newModelQuery()
 * @method static Builder|CompanyActivity newQuery()
 * @method static Builder|CompanyActivity query()
 * @method static Builder|CompanyActivity whereCreatedAt($value)
 * @method static Builder|CompanyActivity whereDeletedAt($value)
 * @method static Builder|CompanyActivity whereId($value)
 * @method static Builder|CompanyActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|CompanyActivity filter($params = [])
 */
class CompanyEmployee extends Model
{

    use HasFactory, softDeletes;

    /**
     * @var string
     */
    protected $table = 'company_employees';

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'role',
        'specialty'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    protected static function booted()
    {
        static::created(function (CompanyEmployee $companyEmployee) {
            $companyEmployee->userEmployeeConnection()->create(['type' => UserEmployeeTypeOptions::TYPE_EMPLOYEE]);
        });

        static::updated(function (CompanyEmployee $companyEmployee) {
            if (!$companyEmployee->userEmployeeConnection) {
                $companyEmployee->userEmployeeConnection()->create(['type' => UserEmployeeTypeOptions::TYPE_EMPLOYEE]);
            }
        });
    }


    /**
     * @return MorphOne
     */
    public function userEmployeeConnection(): MorphOne
    {
        return $this->morphOne(UserEmployeeConnection::class, 'morphable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $params
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['q'])) {
            $builder->where(function ($query) use ($params) {
                $query->orWhere('id', $params['q'])->orWhere('name', 'like', '%' . $params['q'] . '%');
            });
        }

        if (!empty($params['name'])) {
            $builder->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (!empty($params['email'])) {
            $builder->where('email', 'like', '%' . $params['email'] . '%');
        }

        if (!empty($params['phone'])) {
            $builder->where('phone', 'like', '%' . $params['phone'] . '%');
        }

        if (!empty($params['company_ids'])) {
            $builder->whereHas('company', function ($query) use ($params) {
                $query->whereIn('id', (array)$params['company_ids']);
            });
        }

        return $builder;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasCompany(Builder $builder): Builder
    {
        return $builder->whereHas('company');
    }
}
