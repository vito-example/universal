<?php
/**
 *  app\Modules\Pages\Models\Translations\ServiceTranslation.php
 *
 * Date-Time: 9/21/2021
 * Time: 5:22 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;

/**
 * App\Modules\Pages\Models\Translations\ServiceTranslation
 *
 * @property int $id
 * @property int $service_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $seo_meta
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ServiceTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'seo_meta'
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'seo_meta' => 'json',
    ];
}
