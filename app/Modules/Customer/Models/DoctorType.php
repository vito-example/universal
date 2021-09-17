<?php

namespace App\Modules\Customer\Models;

use App\Models\User;
use App\Modules\Admin\Models\BaseModel;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\Translations\CompanyActivityTranslation;
use App\Modules\Customer\Models\Translations\DoctorTypeTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\CompanyActivityFactory;
use Database\Factories\DoctorTypeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Customer\Models\DoctorType
 *
 * @property int $id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $customers
 * @property-read int|null $customers_count
 * @property-read DoctorTypeTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|DoctorTypeTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|DoctorType active($active = 1)
 * @method static Builder|DoctorType filter($params = [])
 * @method static Builder|DoctorType listsTranslations(string $translationField)
 * @method static Builder|DoctorType newModelQuery()
 * @method static Builder|DoctorType newQuery()
 * @method static Builder|DoctorType notTranslatedIn(?string $locale = null)
 * @method static Builder|DoctorType orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|DoctorType orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|DoctorType orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|DoctorType query()
 * @method static Builder|DoctorType translated()
 * @method static Builder|DoctorType translatedIn(?string $locale = null)
 * @method static Builder|DoctorType whereCreatedAt($value)
 * @method static Builder|DoctorType whereDeletedAt($value)
 * @method static Builder|DoctorType whereId($value)
 * @method static Builder|DoctorType whereStatus($value)
 * @method static Builder|DoctorType whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|DoctorType whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|DoctorType whereUpdatedAt($value)
 * @method static Builder|DoctorType withTranslation()
 * @mixin \Eloquent
 */
class DoctorType extends BaseModel
{
    use Translatable,HasFactory;

    const STATUS_ACTIVE  = 1;

    /**
     * @var string
     */
    protected $table = 'doctor_types';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'title'
    ];

    /** @var string */
    protected $translationModel = DoctorTypeTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(User::class,'doctor_types_users','doctor_type_id','user_id');
    }

    /**
     * @param Builder $builder
     * @param int $active
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder, $active = self::STATUS_ACTIVE)
    {
        return $builder->where('status', $active);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return DoctorTypeFactory
     */
    protected static function newFactory()
    {
        return new DoctorTypeFactory();
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $params = [])
    {
        if(!empty($params['q'])) {
            $builder->whereHas('translations',function(Builder $query) use($params){
                $query->where('title','like','%'.$params['q'].'%');
            });
        }
        return $builder;
    }

}
