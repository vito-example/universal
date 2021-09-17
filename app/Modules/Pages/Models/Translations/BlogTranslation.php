<?php

namespace App\Modules\Pages\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Pages\Models\Translations\BlogTranslation
 *
 * @property int $id
 * @property int $blog_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $seo_meta
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class BlogTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
        'seo_meta'
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'seo_meta' => 'json',
    ];
}
