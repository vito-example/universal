<?php

namespace App\Modules\Company\Models;

use App\Modules\Admin\Models\BaseModel;
use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Event\Contracts\EventConnectionAble;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Company\Models\Company
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read Collection|CompanyMember[] $ownerMembers
 * @property-read int|null $owner_members_count
 * @method static Builder|Company filter($params = [])
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company whereDescription($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereTitle($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 * @mixin \Eloquent
 * @method static Builder|Company whereBranchesMeta($value)
 * @method static Builder|Company whereIdentityId($value)
 */
class Company extends BaseModel implements EventConnectionAble
{
    use SoftDeletes, ImageAble, HasFactory;

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'identify_id',
        'address',
        'description',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownerMembers()
    {
        return $this->hasMany(CompanyMember::class)->where('role', CompanyMember::ROLE_OWNER);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id', 'id');
    }

    /**
     *
     * @param int|null $employeeId
     *
     * @return Model|HasMany|object|null
     */
    public function employee(int $employeeId = null)
    {
        return $this->employees()->where('id', $employeeId)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $params = [])
    {
        if (!empty($params['q'])) {
            $builder->where(function ($query) use ($params) {
                $query->orWhere('id', $params['q'])->orWhere('title', 'like', '%' . $params['q'] . '%');
            });
        }
        if (!empty($params['title'])) {
            $builder->where('title', 'like', '%' . $params['title'] . '%');
        }

        if (!empty($params['description'])) {
            $builder->where('description', 'like', '%' . $params['description'] . '%');
        }

        if (!empty($params['date_from'])) {
            $builder->where('created_at', '>=', $params['date_from']);
        }

        if (!empty($params['date_to'])) {
            $builder->where('created_at', '<=', $params['date_to']);
        }

        if (!empty($params['owner'])) {
            $builder->whereHas('ownerMembers.user', function (Builder $builder) use ($params) {
                $builder->filter([
                    'q' => $params['owner']
                ]);
            });
        }

        return $builder;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return CompanyFactory
     */
    protected static function newFactory()
    {
        return new CompanyFactory();
    }

}
