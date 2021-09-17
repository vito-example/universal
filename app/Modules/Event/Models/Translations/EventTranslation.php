<?php

namespace App\Modules\Event\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Event\Models\Translations\EventTranslation
 *
 * @property int $id
 * @property int $event_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $syllabus
 * @property array|null $seo_meta
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class EventTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
        'syllabus',
        'place',
        'seo_meta'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'seo_meta' => 'json',
    ];
}
