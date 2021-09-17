<?php

namespace App\Modules\Base\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Base\Models\Translations\ImageTranslation
 *
 * @property int $id
 * @property int $image_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $alt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Base\Models\Translations\ImageTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ImageTranslation extends BaseTranslationModel
{

    /** @var array */
    protected $fillable = [
        'title',
        'description',
        'alt'
    ];
}
