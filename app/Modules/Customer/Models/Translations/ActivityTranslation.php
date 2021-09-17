<?php

namespace App\Modules\Customer\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use App\Modules\Customer\Models\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Customer\Models\Translations\ActivityTranslation
 *
 * @property int $id
 * @property int $activity_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ActivityTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title',
        'locale',
        'activity_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }

}
