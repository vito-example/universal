<?php
/**
 *  app\Modules\Landing\Http\Resources\Event\EventItemResource.php
 *
 * Date-Time: 8/4/2021
 * Time: 5:31 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Landing\Http\Resources\Event;


use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions;
use App\Modules\Event\Http\Resources\Session\SessionItemResource;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventSession;
use App\Modules\Landing\Http\Resources\Lecturer\LecturerItemResource;
use Illuminate\Support\Collection;
use SeoData;

/**
 * @property Event item
 */
class EventItemResource
{

    /**
     * @var Event|null
     */
    protected ?Event $item;

    /**
     * BlogItemResource constructor.
     *
     * @param Event|null $training
     */
    public function __construct(Event $training = null)
    {
        $this->item = $training;
    }

    /**
     * @return array
     */
    public function toListItem(): array
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'description' => mb_substr(strip_tags($this->item->description), 0, 50, 'utf8') . '...',
            'price' => $this->item->event_meta['price'],
            'form' => $this->item->form,
            'profile_image_url' => $this->item->getImageByKey('profile'),
            'show_url' => route('trainings.show', generateSlug($this->item->id, $this->item->title)),
            'register_url' => route('trainings.register', generateSlug($this->item->id, $this->item->title)),
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return array
     */
    public function toArrayForShow(): array
    {
        return [
            'id' => $this->item->id,
            'title' => $this->item->title,
            'description' => $this->item->description,
            'syllabus' => $this->item->syllabus,
            'place' => $this->item->place,
            'phone' => $this->item->phone,
            'form' => $this->item->form,
            'profile_image' => $this->item->getImageByKey('profile'),
            'created_at' => $this->getDateFormat(),
            'register_url' => route('trainings.register_view', generateSlug($this->item->id, $this->item->title)),
            'request_url' => route('trainings.request_view', generateSlug($this->item->id, $this->item->title)),
            'price' => $this->item->event_meta['price_option_value'] === 'paid_for_all' ? $this->item->event_meta['price'] : '',
            'sessions' => $this->item->sessions ? $this->item->sessions()->active()->pending()->get()->map(function (EventSession $eventSession) {
                return (new SessionItemResource($eventSession))->toRegister();
            }) : [],
            'reviews' => $this->item->review,
            'galleries' => $this->getEventBanners(),
            'lecturers' => count($this->item->lecturers) ? [(new LecturerItemResource($this->item->lecturers()->get()[0]))->toListItem()] : [],
            'files' => !empty($this->item['files_meta']) ? $this->humanMember($this->item['files_meta']) : [],
            'can_request' => $this->item->type === EventTypeOptions::TYPE_REQUEST
        ];
    }

    /**
     * @return mixed
     */
    public function toRegisterItem()
    {
        $user = auth()->user();
        /** @var $item Event */
        $item = $this->item;
        $itemData['id'] = $item->id;
        $itemData['title'] = $item->title;
        $itemData['created_at'] = $this->getDateFormat();
        $itemData['place'] = $item->place;
        $itemData['phone'] = $item->phone;
        $itemData['slug'] = generateSlug($this->item->id, $this->item->title);
        $itemData['price'] = $item->event_meta['price_option_value'] === 'paid_for_all' ? $item->event_meta['price'] : '';
        $itemData['sessions'] = $item->sessions ? $item->sessions()->active()->pending()->get()->map(function (EventSession $eventSession) {
            return (new SessionItemResource($eventSession))->toRegister();
        }) : [];
        $itemData['companies'] = $user->companies ? $user->companies->map(function (Company $company) {
            return (new CompanyItemResource($company))->toRegister();
        }) : [];
        return $itemData;
    }

    /**
     * @return mixed
     */
    public function toRequestItem()
    {
        /** @var $item Event */
        $item = $this->item;
        $itemData['id'] = $item->id;
        $itemData['title'] = $item->title;
        $itemData['created_at'] = $this->getDateFormat();
        $itemData['place'] = $item->place;
        $itemData['phone'] = $item->phone;
        $itemData['slug'] = generateSlug($this->item->id, $this->item->title);
        $itemData['price'] = $item->event_meta['price_option_value'] === 'paid_for_all'
            ? $item->event_meta['price'] / $item->event_meta['price_person_total'] : '';
        $itemData['sessions'] = $item->sessions ? $item->sessions()->active()->get()->map(function (EventSession $eventSession) {
            return (new SessionItemResource($eventSession))->toRegister();
        }) : [];
        $itemData['pending'] = ($this->item->sessions && $this->item->sessionRequests()->where('user_id', auth()->id())->where('status', EventSessionRequestStatusOptions::STATUS_PENDING)->first()) ?? false;
        return $itemData;
    }

    /**
     * @return string
     */
    private function getDateFormat(): string
    {
        if (!$this->item->created_at) {
            return '';
        }
        return $this->item->created_at->format('Y') . ' ' . __('date.month.' . $this->item->created_at->format('M')) . ' ' . $this->item->created_at->format('d');
    }

    /**
     * @return array
     */
    public function toSeoData(): array
    {
        $item = $this->item;
        $description = $item->seo_meta['description'] ?? mb_substr(strip_tags($item->description), 0, 50, 'utf8') . '...';
        $title = $item->seo_meta['title'] ?? $item->title;
        return SeoData::setTitle($title)
            ->setDescription($description)
            ->setKeywords($description)
            ->setOgTitle($title)
            ->setOgDescription($description)
            ->setOgImage($this->item->getImageByKey('profile'))->getSeoData();
    }

    public function getSimilarEvents($limit = 2)
    {
        $directionIds = $this->item->directions->pluck('id')->toArray();

        $similarEvents = Event::whereHas('directions', function ($query) use ($directionIds) {
            return $query->whereIn('id', $directionIds);
        })->where('id', '!=', $this->item->id)
            ->limit($limit)
            ->get();

        if (!count($similarEvents)) {
            $similarEvents = Event::where('form', $this->item->form)
                ->where('id', '!=', $this->item->id)
                ->limit($limit)
                ->get();
        }

        return $similarEvents->map(function ($event) {
            return (new EventItemResource($event))->toListItem();
        });
    }

    /**
     * @param array $humanMeta
     *
     * @return array
     */
    private function humanMember(array $humanMeta = []): array
    {
        if (empty($humanMeta['fields'])) {
            return [];
        }
        $fieldData = [];
        foreach ($humanMeta['fields'] as $fieldKey => $fields) {
            foreach ($fields as $field) {
                if ($field['type'] == 'text') {
                    $fieldData[$fieldKey][$field['name']] = $field['value'];
                } else if ($field['type'] == 'image') {
                    $fieldData[$fieldKey][$field['name']] = !empty($field['image']) ? $field['image']['full_src'] : '';
                } else if ($field['type'] == 'file') {
                    $fieldData[$fieldKey][$field['name']] = !empty($field['file']) ? $field['file']['full_src'] : '';
                }
            }
        }

        return $fieldData;
    }

    /**
     * @return array
     */
    public function toListSeoData(): array
    {
        return SeoData::setTitle(__('seo.training.title'))
            ->setDescription(__('seo.training.description'))
            ->setKeywords(__('seo.training.description'))
            ->setOgTitle(__('seo.training.title'))
            ->setOgDescription(__('seo.training.description'))
            ->getSeoData();
    }

    /**
     * @return Collection
     */
    private function getEventBanners(): Collection
    {
        $item = $this->item;

        return !empty($item->banners_meta['banners']['fields']) ? collect($item->banners_meta['banners']['fields'])->map(function ($banner) {
            $full_src = '';
            if (!empty($banner[0]['file']['full_src'])) {
                $full_src = $banner[0]['file']['full_src'];
            }
            return $full_src;
        }) : collect();
    }

}
