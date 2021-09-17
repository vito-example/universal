<?php

namespace App\Modules\Review\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($get)
 * @method static findOrFail($get)
 */
class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate_id',
        'user_id',
        'content',
        'value',
        'status'
    ];

    public const STATUS_PENDING  = 100;
    public const STATUS_ACCEPTED = 200;
    public const STATUS_DECLINED = 300;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
