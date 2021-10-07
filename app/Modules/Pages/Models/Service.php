<?php
/**
 *  app\Modules\Pages\Models\Service.php
 *
 * Date-Time: 9/19/2021
 * Time: 1:51 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Models;

use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Pages\Models\Translations\ServiceTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Pages\Models\Service
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
 * @property-read ServiceTranslation|null $translation
 * @property-read Collection|ServiceTranslation[] $translations
 * @property-read int|null $translations_count
 * @property mixed description
 * @method static Builder|Service active($active = 1)
 * @method static Builder|Service listsTranslations(string $translationField)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Service onlyTrashed()
 * @method static Builder|Service orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Service orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Service orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Service query()
 * @method static Builder|Service translated()
 * @method static Builder|Service translatedIn(?string $locale = null)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDate($value)
 * @method static Builder|Service whereDeletedAt($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereStatus($value)
 * @method static Builder|Service whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Service whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static Builder|Service withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Service withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Service withoutTrashed()
 * @mixin \Eloquent
 */
class Service extends Model
{
    use SoftDeletes, Translatable, ImageAble;

    /**
     * @var string
     */
    protected $table = 'services';

    const STATUS_ACTIVE  = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'date',
        'status',
        'galleries_meta',
    ];

    /** @var string */
    protected $translationModel = ServiceTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
        'short_description',
        'description',
        'seo_meta'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at',
        'date'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'galleries_meta' => 'json',
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
