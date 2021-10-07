<?php
/**
 *  app\Modules\Pages\Models\Translations\ProjectTranslation.php
 *
 * Date-Time: 9/19/2021
 * Time: 4:57 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;

/**
 * App\Modules\Pages\Models\Translations\ProjectTranslation
 *
 * @property int $id
 * @property int $project_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $seo_meta
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ProjectTranslation extends BaseTranslationModel
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
