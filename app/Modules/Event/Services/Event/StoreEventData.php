<?php


namespace App\Modules\Event\Services\Event;


use App\Modules\Admin\Models\User\Admin;
use App\Modules\Base\Models\Image;
use App\Modules\Customer\Models\Direction;
use App\Modules\Event\Http\Resources\Event\EventItemEditResource;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventSession;
use Arr;
use Carbon\Carbon;

/**
 * @property Event event
 * @property array eventInfo
 * @property array eventOptionData
 * @property array lecturersData
 * @property array sessionsData
 * @property Admin moderator
 * @property array bannersData
 */
class StoreEventData
{
    /**
     * @var
     */
    protected $event;

    /**
     * @var
     */
    protected $eventInfo;

    /**
     * @var
     */
    protected $eventOptionData;

    /**
     * @var
     */
    protected $lecturersData;


    /**
     * @var
     */
    protected $sessionsData;


    /**
     * @var
     */
    protected $moderator;

    /**
     * @var
     */
    protected $bannersData;

    /**
     * @return EventItemEditResource
     */
    public function getEventResource(): EventItemEditResource
    {
        return new EventItemEditResource($this->event);
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param null $eventId
     *
     * @return $this
     */
    public function setEventById($eventId = null): StoreEventData
    {
        $this->event = Event::find($eventId);
        return $this;
    }

    /**
     * @param array $eventInfo
     *
     * @return $this
     */
    public function setInfoData(array $eventInfo = []): StoreEventData
    {
        $this->eventInfo = $eventInfo;
        return $this;
    }

    /**
     * @param array $seoData
     *
     * @return $this
     */
    public function setSeoData(array $seoData = []): StoreEventData
    {
        foreach ($seoData as $key => $data) {
            if (count($data)) {
                $this->eventInfo[$key]['seo_meta'] = $data;
            }
        }
        return $this;
    }

    /**
     * @param array $eventOptionData
     *
     * @return $this
     */
    public function setOptionData(array $eventOptionData = []): StoreEventData
    {
        $this->eventOptionData = $eventOptionData;
        return $this;
    }

    /**
     * @param array|null $lecturersData
     *
     * @return $this
     */
    public function setLecturersData(?array $lecturersData = []): StoreEventData
    {
        $data = [];
        if ($lecturersData !== null && isset($lecturersData['lecturers']['fields'])) {
            foreach ($lecturersData['lecturers']['fields'] as $lecturerField) {
                $data [] = $lecturerField[1]['value'];
            }
        }
        $this->lecturersData = $data;
        return $this;
    }


    /**
     * @param array|null $sessionsData
     *
     * @return $this
     */
    public function setSessionsData(?array $sessionsData = []): StoreEventData
    {
        if ($sessionsData !== null && isset($sessionsData['sessions']['fields'])) {
            $data = [];
            foreach ($sessionsData['sessions']['fields'] as $sessionField) {
                $data [] = [
                    'max_person' => $sessionField[0]['value'],
                    'start_date' => Carbon::parse($sessionField[1]['value'] ?? null),
                    'end_date' => Carbon::parse($sessionField[2]['value'] ?? null),
                    'timezone' => $sessionField[3]['value'],
                    'session_id' => $sessionField[3]['session_id'] ?? 0,
                    'status' => $sessionField[4]['value'],
                    'type' => $sessionField[5]['value'],
                    'user_list' => $sessionField[5]['user_list'],
                    'price' => $sessionField[6]['value'],
                    'link' => $sessionField[7]['value'],
                ];
            }
            $this->sessionsData = $data;
        }
        return $this;
    }

    /**
     * @param array $bannersData
     *
     * @return $this
     */
    public function setBannersData(array $bannersData = []): StoreEventData
    {
        $this->bannersData = $bannersData;
        return $this;
    }

    /**
     * @param Admin $moderator
     *
     * @return $this
     */
    public function setAuthUser(Admin $moderator): StoreEventData
    {
        $this->moderator = $moderator;
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function store()
    {
        $this->createEvent();
        $this->saveImages();
        $this->saveBanners();
        $this->saveOptions();
        $this->saveSessions();
        $this->saveDirections();
        $this->saveLecturers();

        return $this;
    }

    /**
     * @return void
     */
    private function saveOptions(): void
    {
        $this->event->update([
            'event_meta' => !empty($this->eventOptionData['event_meta']) ? $this->eventOptionData['event_meta'] : null,
        ]);
    }

    /**
     * @return void
     */
    private function saveBanners(): void
    {
        $this->event->update([
            'banners_meta' => $this->bannersData
        ]);
    }

    /**
     * @throws \Exception
     */
    private function saveLecturers(): void
    {
        // remove old lecturers
        $this->event->lecturers()->detach();

        if (count($this->lecturersData)) {
            // attach new lecturers
            $this->event->lecturers()->sync($this->lecturersData);
        }
    }

    /**
     * @throws \Exception
     */
    private function saveSessions(): void
    {
        // delete old sessions
        $sessionIds = array_column((array)$this->sessionsData, 'session_id');
        $this->event->sessions()->whereNotIn('id', $sessionIds)->delete();
        // Save/Update employees
        foreach ((array)$this->sessionsData as $session) {
            $sessionId = $session['session_id'];
            $personPermissions = $session['user_list'];
            unset($session['session_id'], $session['user_list']);
            if (!$sessionId) {
                /**
                 * @var EventSession
                 */
                $sessionModel = $this->event->sessions()->create($session);
                $sessionModel->attachSessionPermissions($personPermissions);
                continue;
            }
            $sessionModel = $this->event->session($sessionId);
            $sessionModel->update($session);
            $sessionModel->attachSessionPermissions($personPermissions);
        }
    }

    /**
     *
     */
    private function saveDirections(): void
    {
        // remove old directions
        $this->event->directions()->detach();

        if (isset($this->eventInfo['directions'])) {
            $directions = Direction::whereIn('id',$this->eventInfo['directions'])->get();

            $directionIds = [];
            foreach ($directions as $direction) {
                $directionIds = [...$directionIds,...$direction->getAllChildren()->pluck('id')->toArray()];
                $directionIds [] = $direction->id;
            }

            // attach new directions
            $this->event->directions()->sync(array_unique($directionIds));
        }
    }

    /**
     * @throws \Exception
     */
    private function deleteSessions(): void
    {
        $this->event->sessions()->delete();
    }

    /**
     * @return void
     */
    private function saveImages(): void
    {
        if (empty($this->eventInfo['images'])) {
            return;
        }
        $images = !empty($this->eventInfo['images']) ? $this->eventInfo['images'] : [];
        $itemImages = $this->event->images;

        foreach ($images as $key => $image) {
            $imageModel = Image::findOrFail($image['item']['id']);
            $imageModel->imageable()->associate($this->event);
            $imageModel->save();
            $itemImages = $itemImages->reject(function ($img) use ($imageModel) {
                return $img->id === $imageModel->id;
            });
        }

        $itemImages->map(function ($modelImage) {
            $modelImage->delete();
        });
    }

    /**
     * @return void
     */
    private function createEvent(): void
    {
        $saveData = Arr::except($this->eventInfo, ['images', 'moderator_id', 'files']);
        if ($this->event) {
            $saveData['duration'] = $this->eventInfo['duration'] ?? null;
            $saveData['type'] = $this->eventOptionData['type'];
            $saveData['form'] = $this->eventOptionData['form'];
            $this->event->update($saveData);
            foreach (config('language_manager.locales') as $locale) {
                $this->event->translations()->updateOrCreate([
                    convertCamelCaseToSnakeCase(getModelName($this->event) . '_id') => $this->event->id,
                    'locale' => $locale
                ], $saveData[$locale]);
            }
        } else {
            if (!empty($this->moderator)) {
                $saveData['moderator_id'] = $this->moderator->id;
            }
            $saveData['status'] = EventStatusOptions::STATUS_PROCESSING;
            $saveData['duration'] = $this->eventInfo['duration'] ?? null;
            $saveData['type'] = $this->eventOptionData['type'];
            $saveData['form'] = $this->eventOptionData['form'];
            $this->event = Event::create($saveData);
        }
        $this->event->update([
            'files_meta' => !empty($this->eventInfo['files']) ? $this->eventInfo['files'] : null
        ]);
    }
}
