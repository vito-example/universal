<?php

namespace App\Modules\Base\Models;

use App\Modules\Base\Models\Translations\ImageTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Base\Models\Image
 *
 * @property int $id
 * @property string|null $src
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Base\Models\Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Base\Models\Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Base\Models\Image withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $imageable_id
 * @property string|null $imageable_type
 * @property-read string $full_src
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Image whereImageableType($value)
 */
class Image extends Model
{
    use SoftDeletes;

    /** @var string */
    protected $table = 'images';

    /** @var string[] */
    protected $fillable = [
        'type',
        'src',
        'title',
        'description',
        'alt',
        'imageable_id',
        'imageable_type'
    ];

    /** @var string */
    protected $translationModel = ImageTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
        'description',
        'alt'
    ];

    /** @var array */
    protected $dates = [
        'deleted_at'
    ];

    /** @var string[] */
    protected $appends = [
        'full_src'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getFullSrcAttribute()
    {
        return asset('storage/' . $this->src);
    }

}
