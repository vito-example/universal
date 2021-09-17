<?php

namespace App\Modules\Customer\Models;

use App\Modules\Admin\Models\BaseModel;
use App\Modules\Customer\Models\Translations\ActivityTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Customer\Models\Activity
 *
 * @property int $id
 * @property mixed|null $branch_meta
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read ActivityTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivityTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Activity active($active = 1)
 * @method static Builder|Activity listsTranslations(string $translationField)
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Activity onlyTrashed()
 * @method static Builder|Activity orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Activity orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Activity orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Activity query()
 * @method static Builder|Activity translated()
 * @method static Builder|Activity translatedIn(?string $locale = null)
 * @method static Builder|Activity whereBranchMeta($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDeletedAt($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereStatus($value)
 * @method static Builder|Activity whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Activity whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Activity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Activity withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 */
class Activity extends BaseModel
{
    use SoftDeletes, Translatable,HasFactory;

    /**
     * @var string
     */
    protected $table = 'activities';

    const STATUS_ACTIVE  = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'status'
    ];

    /** @var string */
    protected $translationModel = ActivityTranslation::class;

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
        return new ActivityFactory();
    }

}
