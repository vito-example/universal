<?php

namespace App\Modules\Company\Models;

use App\Modules\Company\Models\Translations\CompanyActivityTranslation;
use App\Modules\Customer\Models\Translations\ActivityTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\ActivityFactory;
use Database\Factories\CompanyActivityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Company\Models\CompanyActivity
 *
 * @property int $id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Company\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read CompanyActivityTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|CompanyActivityTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|CompanyActivity active($active = 1)
 * @method static Builder|CompanyActivity listsTranslations(string $translationField)
 * @method static Builder|CompanyActivity newModelQuery()
 * @method static Builder|CompanyActivity newQuery()
 * @method static Builder|CompanyActivity notTranslatedIn(?string $locale = null)
 * @method static Builder|CompanyActivity orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|CompanyActivity orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|CompanyActivity orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|CompanyActivity query()
 * @method static Builder|CompanyActivity translated()
 * @method static Builder|CompanyActivity translatedIn(?string $locale = null)
 * @method static Builder|CompanyActivity whereCreatedAt($value)
 * @method static Builder|CompanyActivity whereDeletedAt($value)
 * @method static Builder|CompanyActivity whereId($value)
 * @method static Builder|CompanyActivity whereStatus($value)
 * @method static Builder|CompanyActivity whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|CompanyActivity whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|CompanyActivity whereUpdatedAt($value)
 * @method static Builder|CompanyActivity withTranslation()
 * @mixin \Eloquent
 * @method static Builder|CompanyActivity filter($params = [])
 */
class CompanyActivity extends Model
{

    use Translatable,HasFactory;

    const STATUS_ACTIVE  = 1;

    /**
     * @var string
     */
    protected $table = 'company_activities';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'title'
    ];

    /** @var string */
    protected $translationModel = CompanyActivityTranslation::class;

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
    public function companies()
    {
        return $this->belongsToMany(Company::class,'companies_activities','company_activity_id','company_id');
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
     * @return CompanyActivityFactory
     */
    protected static function newFactory()
    {
        return new CompanyActivityFactory();
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
