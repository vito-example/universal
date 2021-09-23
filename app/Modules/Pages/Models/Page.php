<?php

namespace App\Modules\Pages\Models;

use App\Modules\Admin\Models\BaseModel;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;
use Str;

/**
 * App\Modules\Pages\Models\Page
 *
 * @property int $id
 * @property string|null $name
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends BaseModel
{

    /**
     * Pages name.
     */
    const NAME_HOME = 'home';
    const NAME_PROJECT = 'project';
    const NAME_BLOG = 'blog';
    const NAME_TEAM = 'team';
    const NAME_ABOUT = 'about';
    const NAME_CONTACT = 'contact';
    const NAME_SERVICE = 'service';
    const NAME_SOCIAL = 'social';
    const NAME_SEO = 'seo';

    /**
     * @var string
     */
    protected $table = 'pages_meta';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'meta'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'meta' => 'json'
    ];

    /**
     * @return Collection
     */
    public static function getPages()
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'NAME_');
            });
    }

}
