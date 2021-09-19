<?php

namespace App\Modules\Pages\Models;

use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Customer\Models\Direction;
use App\Modules\Pages\Models\Translations\BlogTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Pages\Models\Blog
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
 * @property-read BlogTranslation|null $translation
 * @property-read Collection|BlogTranslation[] $translations
 * @property-read int|null $translations_count
 * @property mixed description
 * @method static Builder|Blog active($active = 1)
 * @method static Builder|Blog listsTranslations(string $translationField)
 * @method static Builder|Blog newModelQuery()
 * @method static Builder|Blog newQuery()
 * @method static Builder|Blog notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Blog onlyTrashed()
 * @method static Builder|Blog orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Blog orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Blog orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Blog query()
 * @method static Builder|Blog translated()
 * @method static Builder|Blog translatedIn(?string $locale = null)
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDate($value)
 * @method static Builder|Blog whereDeletedAt($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereStatus($value)
 * @method static Builder|Blog whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Blog whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @method static Builder|Blog withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Blog withoutTrashed()
 * @mixin \Eloquent
 */
class Blog extends Model
{
    use SoftDeletes, Translatable, ImageAble;

    /**
     * @var string
     */
    protected $table = 'blogs';

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
    protected $translationModel = BlogTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
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
