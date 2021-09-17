<?php
/**
 *  app/Modules/Event/Models/EventSessionRequest.php
 *
 * Date-Time: 28.07.21
 * Time: 11:05
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Models;

use App\Models\User;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Event\Models\EventSessionRequest
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $event_id
 * @property int|null $session_id
 * @property int $max_person
 * @property Carbon|null $date
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Modules\Event\Models\EventSession|null $session
 * @property-read \App\Modules\Event\Models\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession whereUserId($value)
 * @mixin \Eloquent
 * @property-read array|string|null $status_label
 */
class EventSessionRequest extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'event_session_requests';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'session_id',
        'max_person',
        'status',
        'date'
    ];

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

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
     * @return array|string|null
     */
    public function getStatusLabelAttribute()
    {
        return (new EventSessionRequestStatusOptions())->getStatusLabelById($this->status);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeEvent(Builder $builder): Builder
    {
        return $builder->whereHas('event');
    }
}
