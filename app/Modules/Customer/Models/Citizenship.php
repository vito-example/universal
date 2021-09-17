<?php

namespace App\Modules\Customer\Models;

use App\Modules\Admin\Models\BaseModel;
use App\Modules\Customer\Models\Translations\ActivityTranslation;
use App\Modules\Customer\Models\Translations\CitizenshipTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\ActivityFactory;
use Database\Factories\CitizenshipFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Customer\Models\Citizenship
 *
 * @property int $id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read CitizenshipTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|CitizenshipTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Citizenship active($active = 1)
 * @method static Builder|Citizenship listsTranslations(string $translationField)
 * @method static Builder|Citizenship newModelQuery()
 * @method static Builder|Citizenship newQuery()
 * @method static Builder|Citizenship notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Citizenship onlyTrashed()
 * @method static Builder|Citizenship orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Citizenship orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Citizenship orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Citizenship query()
 * @method static Builder|Citizenship translated()
 * @method static Builder|Citizenship translatedIn(?string $locale = null)
 * @method static Builder|Citizenship whereCreatedAt($value)
 * @method static Builder|Citizenship whereDeletedAt($value)
 * @method static Builder|Citizenship whereId($value)
 * @method static Builder|Citizenship whereStatus($value)
 * @method static Builder|Citizenship whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Citizenship whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Citizenship whereUpdatedAt($value)
 * @method static Builder|Citizenship withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Citizenship withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Citizenship withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $country_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @method static Builder|Citizenship whereCountryCode($value)
 */
class Citizenship extends BaseModel
{
    use SoftDeletes, Translatable, HasFactory;

    /**
     * Country codes.
     */
    const COUNTRY_CODE_GE   = 'ge';

    /**
     * @var string
     */
    protected $table = 'citizenship';

    const STATUS_ACTIVE  = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'status',
        'country_code'
    ];

    /** @var string */
    protected $translationModel = CitizenshipTranslation::class;

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
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new CitizenshipFactory();
    }

}
