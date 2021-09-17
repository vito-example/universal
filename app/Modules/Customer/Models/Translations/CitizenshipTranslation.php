<?php

namespace App\Modules\Customer\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Customer\Models\Translations\CitizenshipTranslation
 *
 * @property int $id
 * @property int $citizenship_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation whereCitizenshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitizenshipTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class CitizenshipTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title'
    ];
}
