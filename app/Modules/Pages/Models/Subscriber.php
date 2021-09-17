<?php

namespace App\Modules\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Pages\Models\Subscriber
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $last_name
 * @property string|null $email
 * @property int|null $is_subscribed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Query\Builder|Subscriber onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Subscriber withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Subscriber withoutTrashed()
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    use SoftDeletes;

    const SUBSCRIBED_YES        = 1;
    const SUBSCRIBED_NO         = 2;

    /**
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'is_subscribed'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * @return array
     */
    public function toExport()
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'is_subscribed' => $this->is_subscribed
        ];
    }

}
