<?php
/**
 *  app\Modules\Customer\Models\Lecturer.php
 *
 * Date-Time: 7/8/2021
 * Time: 7:27 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Models;

use App\Modules\Admin\Models\BaseModel;
use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Customer\Models\Translations\ActivityTranslation;
use App\Modules\Customer\Models\Translations\LecturerTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\LecturerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Customer\Models\Lecturer
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
 * @property mixed description
 */
class Lecturer extends BaseModel
{
    use SoftDeletes, Translatable, ImageAble, HasFactory;

    /**
     * @var string
     */
    protected $table = 'lecturers';

    const STATUS_ACTIVE = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'status'
    ];

    /** @var string */
    protected $translationModel = LecturerTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'full_name',
        'description'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['q'])) {
            $builder->where(function ($query) use ($params) {
                $query->orWhere('id', $params['q']);
            });
        }

        if (!empty($params['full_name'])) {
            $builder->whereHas('translations', function (Builder $query) use ($params) {
                $query->where('full_name', 'like', '%' . $params['full_name'] . '%');
            });
        }

        if (!empty($params['status'])) {
            $builder->where('status', '=', $params['status'] == -1 ? 0 : 1);
        }

        if (!empty($params['direction'])) {
            $builder->whereHas('directions', function (Builder $builder) use ($params) {
                $builder->filter([
                    'q' => $params['direction']
                ]);
            });
        }

        if (!empty($params['direction_ids'])) {
            $builder->whereHas('directions', function ($query) use ($params) {
                $query->whereIn('id', $params['direction_ids']);
            });
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param int $active
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder, int $active = self::STATUS_ACTIVE): Builder
    {
        return $builder->where('status', $active);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return new LecturerFactory();
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return BelongsToMany
     */
    public function directions(): BelongsToMany
    {
        return $this->belongsToMany(Direction::class, 'lecturers_directions');
    }
}
