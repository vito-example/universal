<?php

namespace App\Modules\Customer\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Customer\Models\Translations\DoctorTypeTranslation
 *
 * @property int $id
 * @property int $doctor_type_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation whereDoctorTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTypeTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class DoctorTypeTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title'
    ];
}
