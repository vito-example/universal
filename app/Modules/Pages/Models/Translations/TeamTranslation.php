<?php

namespace App\Modules\Pages\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;

/**
 * App\Modules\Pages\Models\Translations\ProjectTranslation
 *
 * @property int $id
 * @property int $team_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $about
 * @property string|null $position
 * @property string|null $seo_meta
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class TeamTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'name',
        'about',
        'position',
        'seo_meta'
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'seo_meta' => 'json',
    ];
}
