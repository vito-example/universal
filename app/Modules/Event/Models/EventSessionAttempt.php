<?php
/**
 *  app\Modules\Event\Models\EventSessionAttempt.php
 *
 * Date-Time: 8/16/2021
 * Time: 8:46 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Event\Models\EventSessionAttempt
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $session_id
 * @property int $person_total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $user
 * @property-read EventSession|null $session
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSessionAttempt whereUserId($value)
 * @mixin \Eloquent
 */
class EventSessionAttempt extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'event_session_attempts';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'person_total',
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(EventSession::class, 'session_id', 'id');
    }

    /**
     * @return HasOneThrough
     */
    public function event(): HasOneThrough
    {
        return $this->hasOneThrough(Event::class, EventSession::class, 'id', 'id', 'session_id', 'event_id');
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['statuses'])) {
            $builder->whereIn('status', $params['statuses']);
        }

        if (!empty($params['date_from'])) {
            $builder->where('created_at', '>=', $params['date_from']);
        }

        if (!empty($params['date_to'])) {
            $builder->where('created_at', '<=', $params['date_to']);
        }

        if (!empty($params['event'])) {
            $builder->whereHas('event', function ($query) use ($params) {
                $query->whereHas('translations', function ($query) use ($params) {
                    $query->where('title', 'like', '%' . $params['event'] . '%');
                });
            });
        }

        if (!empty($params['user'])) {
            $builder->whereHas('user', function (Builder $builder) use ($params) {
                $builder->filter([
                    'q' => $params['user']
                ]);
            });
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param int $active
     *
     * @return Builder
     */
    public function scopeEvent(Builder $builder): Builder
    {
        return $builder->whereHas('event');
    }
}
