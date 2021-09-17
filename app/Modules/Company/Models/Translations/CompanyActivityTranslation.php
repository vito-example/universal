<?php

namespace App\Modules\Company\Models\Translations;

use App\Modules\Admin\Models\BaseTranslationModel;
use App\Modules\Company\Models\CompanyActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Company\Models\Translations\CompanyActivityTranslation
 *
 * @property int $id
 * @property int $company_activity_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation whereCompanyActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyActivityTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class CompanyActivityTranslation extends BaseTranslationModel
{
    /** @var string[] */
    protected $fillable = [
        'title',
        'locale',
        'company_activity_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(CompanyActivity::class,'company_activity_id','id');
    }

}
