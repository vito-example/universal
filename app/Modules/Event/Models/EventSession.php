<?php
/**
 *  app/Modules/Event/Models/EventSession.php
 *
 * Date-Time: 14.07.21
 * Time: 15:02
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Models;

use App\Models\User;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Services\Customer\CustomerCompanyEmployee;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Modules\Event\Models\EventAttendee
 *
 * @property int $id
 * @property int|null $event_id
 * @property int $max_person
 * @property int|null $price
 * @property string|null $link
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int|null $status
 * @property int $type
 * @property string|null $timezone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
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
class EventSession extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'event_sessions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'max_person',
        'price',
        'status',
        'start_date',
        'end_date',
        'timezone',
        'type',
        'link'
    ];

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
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
            $builder->where('start_date', '>=', $params['date_from']);
        }
        if (!empty($params['date_to'])) {
            $builder->where('end_date', '<=', $params['date_to']);
        }

        if (!empty($params['event'])) {
            $builder->whereHas('event', function ($query) use ($params) {
                $query->whereHas('translations', function ($query) use ($params) {
                    $query->where('title', 'like', '%' . $params['event'] . '%');
                });
            });
        }

        return $builder;
    }

    /**
     * @return array|string|null
     */
    public function getStatusLabelAttribute()
    {
        return (new EventSessionStatusOptions())->getStatusLabelById($this->status);
    }

    /**
     * @return BelongsToMany
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(UserEmployeeConnection::class, 'event_sessions_attendees', 'session_id', 'person_con_id', 'id');
    }

    /**
     * @param null $userId
     *
     * @return bool
     */
    public function isInAttendees($userId = null): bool
    {
        return $this->attendees->where('id', $userId)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_sessions_users', 'session_id', 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function userAttendees(): BelongsToMany
    {
        return $this->attendees()->where('users_employees_connections.morphable_type', '=', User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function employeeAttendees(): BelongsToMany
    {
        return $this->attendees()
            ->where('users_employees_connections.morphable_type', '=', CompanyEmployee::class);
    }

    /**
     * @return int
     */
    public function getRegisterPersonCountAttribute(): int
    {
        return $this->attendees()->count();
    }

    /**
     * @param $userPermissions
     */
    public function attachSessionPermissions($userPermissions): void
    {
        // Remove old permissions
        $this->userPermissions()->detach();

        if ($this->type !== EventSessionTypeOptions::SESSION_TYPE_REQUEST) {
            return;
        }

        $this->userPermissions()->attach($userPermissions);

        // Get user ids which permissions denied but attends
        $userIdsWhichPermissionsDenied = $this->attendees()->where('morphable_type', User::class)->whereNotIn('morphable_id', $userPermissions)->pluck('morphable_id')->toArray();

        // Every unique employee which permissions Denied to session
        $employeesIdsWhichLosePermissions = (new CustomerCompanyEmployee($userIdsWhichPermissionsDenied))->setUsers()->getCompanyEmployeeIdsByUsers();


        // Every unique employee which have permission Access to session
        $employeesIdsWhichHavePermissionsAccess = (new CustomerCompanyEmployee($userPermissions))->setUsers()->getCompanyEmployeeIdsByUsers();

        // filter employees which lose permissions to session. this ids array help us to detach attends which not access to this session...
        $filterEmployeesWhichLosePermissions = array_diff($employeesIdsWhichLosePermissions, $employeesIdsWhichHavePermissionsAccess);

        // Get users which permissions denied but attends
        $userPermissionsDenied = $this->attendees()->where('morphable_type', User::class)->whereNotIn('morphable_id', $userPermissions)->pluck('id');

        $employeesIdsWhichLosePermissions = $this->attendees()->where('morphable_type', CompanyEmployee::class)->whereIn('morphable_id', $filterEmployeesWhichLosePermissions)->pluck('id');
        $this->attendees()->detach([...$userPermissionsDenied, ...$employeesIdsWhichLosePermissions]);
    }

    /**
     * @param Builder $builder
     * @param int $active
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder, int $active = EventSessionStatusOptions::STATUS_ACTIVE): Builder
    {
        return $builder->where('status', $active);
    }

    public function scopePending(Builder $builder, int $active = EventSessionStatusOptions::STATUS_ACTIVE): Builder
    {
        return $builder->where('end_date', '>', Carbon::now());
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
