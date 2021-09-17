<?php

namespace App\Modules\Event\Models;

use App\Models\User;
use App\Modules\Admin\Models\BaseModel;
use App\Modules\Admin\Models\User\Admin;
use App\Modules\Base\Models\Image;
use App\Modules\Base\Traits\ImageAble;
use App\Modules\Customer\Models\Direction;
use App\Modules\Customer\Models\Lecturer;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use App\Modules\Event\Models\Translations\EventTranslation;
use App\Modules\Review\Models\Review;
use Astrotomic\Translatable\Translatable;
use Database\Factories\EventFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Str;

/**
 * App\Modules\Event\Models\Event
 *
 * @property int $id
 * @property int|null $moderator_id
 * @property array|null $event_meta
 * @property int|null $duration
 * @property int|null $type
 * @property int|null $form
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read Admin|null $moderator
 * @property-read EventTranslation|null $translation
 * @property-read Collection|EventTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Event listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Event translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLecturersMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 * @mixin \Eloquent
 * @property-read Collection|User[] $attendees
 * @property-read int|null $attendees_count
 * @property-read Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read array|Application|Translator|string|null $status_label
 * @method static Builder|Event filter($params = [])
 * @property array|null $files_meta
 * @method static Builder|Event whereFilesMeta($value)
 * @property-read mixed|string $conference_iframe
 * @property array|null $banners_meta
 * @method static Builder|Event whereBannersMeta($value)
 * @property-read int|null $connections_count
 * @property mixed description
 */
class Event extends BaseModel
{
    use SoftDeletes, Translatable,ImageAble, HasFactory;

    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * @var string[]
     */
    protected $fillable = [
        'moderator_id',
        'event_meta',
        'duration',
        'status',
        'type',
        'form',
        'files_meta',
        'banners_meta',
        'phone'
    ];

    /** @var string */
    protected $translationModel = EventTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
        'description',
        'syllabus',
        'place',
        'seo_meta'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'event_meta' => 'json',
        'files_meta' => 'json',
        'banners_meta' => 'json'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function review()
    {
        return $this->morphMany(Review::class, 'model');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moderator()
    {
        return $this->belongsTo(Admin::class, 'moderator_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return HasMany
     */
    public function sessions(): hasMany
    {
        return $this->hasMany(EventSession::class, 'event_id');
    }

    /**
     *
     * @param int|null $sessionId
     * @return Model|HasMany|object|null
     */
    public function session(int $sessionId = null)
    {
        return $this->sessions()->where('id', $sessionId)->first();
    }


    /**
     * @return HasMany
     */
    public function sessionRequests(): hasMany
    {
        return $this->hasMany(EventSessionRequest::class, 'event_id');
    }

    /**
     * @return BelongsToMany
     */
    public function directions(): BelongsToMany
    {
        return $this->belongsToMany(Direction::class, 'events_directions');
    }

    /**
     * @return BelongsToMany
     */
    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(Lecturer::class, 'events_lecturers');
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['moderator_id'])) {
            $builder->where('moderator_id', $params['moderator_id']);
        }
        if (!empty($params['q'])) {
            $builder->whereHas('translations', function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params['q'] . '%');
            });
        }
        if (!empty($params['title'])) {
            $builder->whereHas('translations', function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params['title'] . '%');
            });
        }
        if (!empty($params['statuses'])) {
            $builder->whereIn('status', $params['statuses']);
        }
        if (!empty($params['status'])) {
            $builder->where('status', $params['status']);
        }
        if (!empty($params['types'])) {
            $builder->whereIn('type', $params['types']);
        }
        if (!empty($params['forms'])) {
            $builder->whereIn('form', $params['forms']);
        }

        if (!empty($params['date_from'])) {
            $builder->whereHas('sessions', function ($query) use ($params) {
                $query->where('start_date', '>=', $params['date_from']);
            });
        }
        if (!empty($params['date_to'])) {
            $builder->whereHas('sessions', function ($query) use ($params) {
                $query->where('end_date', '<=', $params['date_to']);
            });
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param int $status
     * @return Builder
     */
    public function scopeStatus(Builder $builder, int $status = EventStatusOptions::STATUS_ORGANIZED): Builder
    {
        return $builder->where('status', '=', $status);
    }

    /**
     * @param Builder $builder
     * @param int $form
     * @return Builder
     */
    public function scopeForm(Builder $builder, int $form = EventFormOptions::FORM_OFFLINE): Builder
    {
        return $builder->where('form', '=', $form);
    }

    /**
     * @return array|Application|Translator|string|null
     */
    public function getStatusLabelAttribute()
    {
        return (new EventStatusOptions())->getStatusLabelById($this->status);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new EventFactory();
    }

    /**
     * @return bool
     */
    public function isOrganized(): bool
    {
        return $this->status === EventStatusOptions::STATUS_ORGANIZED;
    }

    /**
     * @return mixed|string
     */
    public function getConferenceUrlAttribute()
    {
        return !empty($this->event_meta['url']) ? $this->event_meta['url'] : '';
    }

    /**
     * @return mixed|string
     */
    public function getConferenceIframeAttribute()
    {
        return !empty($this->event_meta['iframe']) ? $this->event_meta['iframe'] : '';
    }

    /**
     * @return string
     */
    public function getConferenceInsideUrlAttribute()
    {
        return route('event.conference_url', [$this->id, Str::slug($this->title)]);
    }

}
