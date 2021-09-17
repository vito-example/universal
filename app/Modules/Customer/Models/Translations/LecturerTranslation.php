<?php
/**
 *  app\Modules\Customer\Models\Translations\LecturerTranslation.php
 *
 * Date-Time: 7/8/2021
 * Time: 7:43 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use App\Modules\Customer\Models\Lecturer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Modules\Customer\Models\Translations\LecturerTranslation
 *
 * @property int $id
 * @property int $lecturer_id
 * @property string $locale
 * @property string|null $full_name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class LecturerTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'full_name',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }

}
