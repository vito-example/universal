<?php
/**
 *  app/Modules/Customer/Models/Translations/DirectionTranslation.php
 *
 * Date-Time: 06.07.21
 * Time: 16:48
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Modules\Customer\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use App\Modules\Customer\Models\Direction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DirectionTranslation
 * @package App\Modules\Customer\Models\Translations
 *
 * @property int $id
 * @property int $direction_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectionTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class DirectionTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class,'direction_id','id');
    }
}
