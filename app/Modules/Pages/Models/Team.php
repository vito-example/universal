<?php
/**
 *  app\Modules\Pages\Models\Team.php
 *
 * Date-Time: 9/19/2021
 * Time: 4:56 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Models;

use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Pages\Models\Translations\ProjectTranslation;
use App\Modules\Pages\Models\Translations\TeamTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Pages\Models\Team
 *
 * @property int $id
 * @property Carbon|null $date
 * @property int|null $status
 * @property array|null $galleries_meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read TeamTranslation|null $translation
 * @property-read Collection|TeamTranslation[] $translations
 * @property-read int|null $translations_count
 * @property mixed description
 * @method static Builder|Team active($active = 1)
 * @method static Builder|Team listsTranslations(string $translationField)
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Team onlyTrashed()
 * @method static Builder|Team orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Team orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Team orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Team query()
 * @method static Builder|Team translated()
 * @method static Builder|Team translatedIn(?string $locale = null)
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereDate($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereStatus($value)
 * @method static Builder|Team whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Team whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Team withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Team withoutTrashed()
 * @mixin \Eloquent
 */
class Team extends Model
{
    use SoftDeletes, Translatable, ImageAble;

    /**
     * @var string
     */
    protected $table = 'teams';

    const STATUS_ACTIVE  = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'about',
        'position',
        'status',
    ];

    /** @var string */
    protected $translationModel = TeamTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'name',
        'about',
        'position',
        'seo_meta'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at',
    ];


    /**
     * @param Builder $builder
     * @param int $active
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder, $active = self::STATUS_ACTIVE): Builder
    {
        return $builder->where('status', $active);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
