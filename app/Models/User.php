<?php

namespace App\Models;

use App\Modules\Company\Http\Resources\CompanyEmployee\UserEmployeeTypeOptions;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Company\Models\CompanyMember;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Auth\Interfaces\MustVerifyPhone;
use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\DoctorType;
use App\Modules\Event\Contracts\EventConnectionAble;
use App\Modules\Event\Http\Resources\Session\SessionItemResource;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventSession;
use App\Modules\Review\Models\Review;
use Arr;
use Database\Factories\ActivityFactory;
use Database\Factories\CustomerFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $surname
 * @property string|null $phone_number
 * @property int|null $terms
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property int|null $status
 * @method static Builder|User filter($params = [])
 * @method static Builder|User whereAdvertisement($value)
 * @method static Builder|User whereCitizenshipId($value)
 * @method static Builder|User wherePassportNumber($value)
 * @method static Builder|User wherePersonalNumber($value)
 * @method static Builder|User wherePhoneNumber($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereSurname($value)
 * @method static Builder|User whereTerms($value)
 * @method static Builder|User whereVerifiedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|CompanyMember[] $ownCompanies
 * @property-read int|null $own_companies_count
 */
class User extends Authenticatable implements MustVerifyPhone, EventConnectionAble
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use \App\Modules\Customer\Auth\Traits\MustVerifyPhone;

    /**
     * Status list.
     */
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'phone_number',
        'terms',
        'email',
        'password',
        'profile_photo_path',
        'provider',
        'provider_id',
        'status',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'full_name'
    ];

    protected static function booted()
    {
        static::created(function (User $user) {
            $user->userEmployeeConnection()->create(['type' => UserEmployeeTypeOptions::TYPE_USER]);
        });

        static::updated(function (User $user) {
            if (!$user->userEmployeeConnection) {
                $user->userEmployeeConnection()->create(['type' => UserEmployeeTypeOptions::TYPE_USER]);
            }
        });
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    /**
     * @return MorphOne
     */
    public function userEmployeeConnection(): MorphOne
    {
        return $this->morphOne(UserEmployeeConnection::class, 'morphable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownCompanies()
    {
        return $this->hasMany(CompanyMember::class)->where('role', CompanyMember::ROLE_OWNER);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $params = [])
    {
        if (!empty($params['q'])) {
            $builder->where(function ($query) use ($params) {
                $query->orWhere('id', $params['q'])->orWhere('name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('surname', 'like', '%' . $params['q'] . '%');
            });
        }
        if (!empty($params['email'])) {
            $builder->where('email', 'like', '%' . $params['email'] . '%');
        }
        if (!empty($params['name'])) {
            $builder->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['surname'])) {
            $builder->where('surname', 'like', '%' . $params['surname'] . '%');
        }
        if (!empty($params['phone_number'])) {
            $builder->where('phone_number', 'like', '%' . $params['phone_number'] . '%');
        }
        if (!empty($params['is_verify'])) {
            $builder->where('verified_at', $params['is_verify'] == 1 ? '=' : '!=', null);
        }
        if (!empty($params['date_from'])) {
            $builder->whereDate('created_at', '>=', $params['date_from']);
        }
        if (!empty($params['date_to'])) {
            $builder->whereDate('created_at', '<=', $params['date_to']);
        }


        return $builder;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return new CustomerFactory();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * @return HasManyThrough
     */
    public function companies(): HasManyThrough
    {
        return $this->hasManyThrough(Company::class, CompanyMember::class, 'user_id', 'id', 'id', 'company_id');
    }

    /**
     * @param null $event
     * @return array
     */
    public function trainings($event = null)
    {
        $employeeIds = $this->companies ? $this->companies->map(function (Company $company) {
            return $company->employees ? $company->employees->pluck('id')->toArray() : [];
        }) : [];

        $employeeIds = array_unique(Arr::flatten((array)$employeeIds));


        $userEmployeeConnections = UserEmployeeConnection::whereIn('morphable_id', $employeeIds)->where('morphable_type', CompanyEmployee::class)->pluck('id')->toArray();
        $userEmployeeConnections [] = $this->userEmployeeConnection->id;
        $eventSessions = EventSession::query();
        if ($event) {
            $eventSessions = $eventSessions->where('event_id', $event->id);
        }

        $eventSessions = $eventSessions->whereHas('attendees', function ($query) use ($userEmployeeConnections) {
            $query->whereIn('person_con_id', $userEmployeeConnections);
        })->event()->orderBy('start_date','desc');

        $eventSessions = $eventSessions->get();


        return empty($eventSessions) ? []
            : $eventSessions->map(function ($eventSession) use ($employeeIds) {
                return (new SessionItemResource($eventSession))->toProfile($employeeIds);
            });
    }
}
