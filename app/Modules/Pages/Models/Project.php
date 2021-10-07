<?php
/**
 *  app\Modules\Pages\Models\Project.php
 *
 * Date-Time: 9/19/2021
 * Time: 1:51 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Models;

use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Pages\Models\Translations\ProjectTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Pages\Models\Project
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
 * @property-read ProjectTranslation|null $translation
 * @property-read Collection|ProjectTranslation[] $translations
 * @property-read int|null $translations_count
 * @property mixed description
 * @method static Builder|Project active($active = 1)
 * @method static Builder|Project listsTranslations(string $translationField)
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Project onlyTrashed()
 * @method static Builder|Project orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Project orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Project orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Project query()
 * @method static Builder|Project translated()
 * @method static Builder|Project translatedIn(?string $locale = null)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDate($value)
 * @method static Builder|Project whereDeletedAt($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereStatus($value)
 * @method static Builder|Project whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Project whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Project withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Project withoutTrashed()
 * @mixin \Eloquent
 */
class Project extends Model
{
    use SoftDeletes, Translatable, ImageAble;

    /**
     * @var string
     */
    protected $table = 'projects';

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
    protected $translationModel = ProjectTranslation::class;

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
