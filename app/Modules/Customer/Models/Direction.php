<?php
/**
 *  app/Modules/Customer/Models/Direction.php
 *
 * Date-Time: 06.07.21
 * Time: 16:46
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Models;

use App\Modules\Admin\Models\BaseModel;
use App\Modules\Customer\Models\Translations\DirectionTranslation;
use Astrotomic\Translatable\Translatable;
use Database\Factories\DirectionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Direction
 * @package App\Modules\Customer\Models
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read DirectionTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|DirectionTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Direction active($active = 1)
 * @method static Builder|Direction listsTranslations(string $translationField)
 * @method static Builder|Direction newModelQuery()
 * @method static Builder|Direction newQuery()
 * @method static Builder|Direction notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Direction onlyTrashed()
 * @method static Builder|Direction orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Direction orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Direction orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Direction query()
 * @method static Builder|Direction translated()
 * @method static Builder|Direction translatedIn(?string $locale = null)
 * @method static Builder|Direction whereBranchMeta($value)
 * @method static Builder|Direction whereCreatedAt($value)
 * @method static Builder|Direction whereDeletedAt($value)
 * @method static Builder|Direction whereId($value)
 * @method static Builder|Direction whereStatus($value)
 * @method static Builder|Direction whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Direction whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Direction whereUpdatedAt($value)
 * @method static Builder|Direction withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Direction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Direction withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 */
class Direction extends BaseModel
{
    use SoftDeletes, Translatable, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'directions';

    public const STATUS_ACTIVE = 1;

    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'status'
    ];

    /**
     * @var string
     */
    protected $translationModel = DirectionTranslation::class;

    /**
     * @var string[]
     */
    public $translatedAttributes = [
        'title'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    protected static function booted() {
        static::deleting( function ($direction) {
            $direction->directions->each(function($direction){ //edit after comment
                $direction->delete();
            });
        });
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $params = []): Builder
    {
        if(!empty($params['q'])) {
            $builder->whereHas('translations',function(Builder $query) use($params){
                $query->where('title','like','%'.$params['q'].'%');
            });
        }
        return $builder;
    }

    /**
     * @return HasMany
     */
    public function directions(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parentDirection(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parentDirection;
        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parentDirection;
        }
        $parents = $parents->sortBy('id');
        return $parents;
    }

    /**
     * @return HasMany
     */
    public function childDirections(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id')->with('directions');
    }

    /**
     * @return HasMany
     */
    public function childrenRecursive(): HasMany
    {
        return $this->directions()->with('childrenRecursive');
    }

    /**
     * @return HasMany
     */
    public function childrenRecursiveDelete(): HasMany
    {
        return $this->childrenRecursive()->with('childrenRecursiveDelete')->delete();
    }

    /**
     * @return Collection
     */
    public function getAllChildren (): Collection
    {
        $sections = new Collection();

        foreach ($this->directions as $direction) {
            $sections->push($direction);
            $sections = $sections->merge($direction->getAllChildren());
        }

        return $sections;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $active
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder, int $active = self::STATUS_ACTIVE): Builder
    {
        return $builder->where('status', $active);
    }

    /**
     * @return \Database\Factories\DirectionFactory
     */
    protected static function newFactory(): DirectionFactory
    {
        return new DirectionFactory();
    }


    /**
     *  Return direction level
     * @return int
     */
    public function getLevelAttribute(): int
    {
        if ($this->parent_id === null) {
            return 1;
        }
        if (count($this->childDirections)) {
            return 2;
        }
        return 3;
    }
}
