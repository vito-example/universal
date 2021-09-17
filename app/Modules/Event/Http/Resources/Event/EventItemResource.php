<?php


namespace App\Modules\Event\Http\Resources\Event;


use App\Modules\Customer\Http\Resources\Lecturer\LecturerListResource;
use App\Modules\Event\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;
use SeoData;
use Str;

class EventItemResource extends JsonResource
{

    /**
     * EventItemResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param null $request
     *
     * @return array
     */
    public function toArray($request = null)
    {
        /** @var $item Event */
        $item = $this->resource;
        $itemData = [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'syllabus' => $item->syllabus,
            'type' => $item->type,
            'form' => $item->form,
            'duration' => $item->duration,
        ];
        $itemData['profile_image_url'] = $this->getProfileImageUrl($item);
        if (!empty($item->event_meta['price_option_value'])) {
            $itemData['price_option_label'] = (new EventPriceOptions())->getPriceOptionByValue($item->event_meta['price_option_value']);
        } else {
            $itemData['price_option_label'] = '';
        }
        if (!empty($item->event_meta['price_option_value']) && $item->event_meta['price_option_value'] === EventPriceOptions::EVENT_PRICE_PAID_FOR_ALL
            && !empty($item->event_meta['price'])) {
            $itemData['price_for_all'] = $item->event_meta['price'];
            $itemData['price_person_total'] = $item->event_meta['price_person_total'];
        } else {
            $itemData['price_for_all'] = 0;
        }
        $itemData['directions'] = $item->directions;
        $itemData['lecturers'] = $item->lecturers;
        $itemData['sessions'] = $item->sessions;
        if (auth()->guard('admin') && auth()->user()) {
            $itemData['event_url'] = $item->conference_url;
        }

        return $itemData;
    }

    /**
     * @return array
     */
    public function toShowItem()
    {
        /** @var $item Event */
        $item = $this->resource;
        $itemData = [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
        ];
        $itemData['profile_image_url'] = $this->getProfileImageUrl($item);

        if (!empty($item->event_meta['price_option_value'])) {
            $itemData['price_option_label'] = (new EventPriceOptions())->getPriceOptionByValue($item->event_meta['price_option_value']);
        } else {
            $itemData['price_option_label'] = '';
        }
        if (!empty($item->event_meta['price_option_value']) && $item->event_meta['price_option_value'] === EventPriceOptions::EVENT_PRICE_PAID_FOR_ALL
            && !empty($item->event_meta['price'])) {
            $itemData['price_for_all'] = $item->event_meta['price'];
        } else {
            $itemData['price_for_all'] = 0;
        }
        $priceActivities = [];

        $itemData['files'] = !empty($item['files_meta']) ? $this->humanMember($item['files_meta']) : [];
        $itemData['lecturers'] = new LecturerListResource($item->lecturers);
        $itemData['banners'] = $this->getEventBanners();
        $itemData['moderator'] = $this->getModeratorData();
        $itemData['conference_url'] = $item->conference_inside_url;

        if (auth()->guard('admin') && auth()->user()) {
            $itemData['event_url'] = $item->conference_url;
        }

        return $itemData;
    }

    /**
     * @return mixed
     */
    public function toListItem()
    {
        /** @var $item Event */
        $item = $this->resource;
        $itemData['id'] = $item->id;
        $itemData['title'] = $item->title;
        $itemData['syllabus'] = $item->syllabus;
        $itemData['description'] = Str::limit($item->description, 110);
        $itemData['profile_image_url'] = $this->getProfileImageUrl($item);
        $itemData['show_url'] = route('trainings.show', generateSlug($item->id, $item->title));
        $itemData['register_url'] = route('trainings.register', generateSlug($item->id, $item->title));
        $itemData['created_at'] = $this->getDateFormat();
        $itemData['price'] = $item->event_meta['price_option_value'] === 'paid_for_all'
            ? $item->event_meta['price']/$item->event_meta['price_person_total'] : '';

        return $itemData;
    }

    /**
     * @return array
     */
    public function toCalendarItem(): array
    {
        /** @var $item Event */
        $item = $this->resource;

        $itemData = [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'profile_image_url' => $this->getProfileImageUrl($item),
            'show_url' => route('event.show', generateSlug($item->id, $item->title)),
            'start_date' => $item->start_date ? $item->start_date->format('Y-m-d') : '',
            'calendar_data' => (new EventCalendarResource($item))->toArray(),
            'conference_url' => $item->conference_url
        ];

        return $itemData;
    }

    /**
     * @return string
     */
    private function getDateFormat()
    {
        if (!$this->resource->created_at) {
            return '';
        }
        return $this->resource->created_at->format('Y') . ' '  . __('date.month.' . $this->resource->created_at->format('M')) . ' ' . $this->resource->created_at->format('d');
    }

    /**
     * @param Event $item
     *
     * @return string
     */
    private function getProfileImageUrl(Event $item): string
    {
        $profileImage = $item->images->where('type', 'profile')->first();
        return $profileImage ? $profileImage->full_src : '';
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
    public function toConferenceItem()
    {
        /** @var $item Event */
        $item = $this->resource;
        $questionsData = [];

        if ($isSpeaker = $item->isSpeaker(auth()->user())) {
            $questions = $item->questions->where('user_id',auth()->id());
            $questionsData = (new QuestionListResource($questions))->toArray();
        }

        $itemData = [
            'id' => $item->id,
            'title' => $item->title,
            'slug' => Str::slug($item->title),
            'description' => $item->description,
            'profile_image_url' => $this->getProfileImageUrl($item),
            'show_url' => route('event.show', generateSlug($item->id, $item->title)),
            'start_date' => $item->start_date ? $item->start_date->format('d.m.Y H:i:s') : '',
            'iframe' => $item->conference_iframe,
            'questions' => $questionsData,
            'banners' => $this->getEventBanners(),
            'speakers' => (new EventConnectionResources())->setEvent($item)->setConnectionType('speakers')->getResources(),
            'files' => $itemData['files'] = !empty($item['files_meta']) ? $this->humanMember($item['files_meta']) : []
        ];

        return $itemData;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getEventBanners()
    {
        /** @var $item Event */
        $item = $this->resource;

        return !empty($item->banners_meta['banners']['fields']) ? collect($item->banners_meta['banners']['fields'])->map(function ($banner) {
            return collect($banner)->map(function ($bannerField) {
                $value = !empty($bannerField['value']) ? $bannerField['value'] : '';
                if (!empty($bannerField['file']['full_src'])) {
                    $value = $bannerField['file']['full_src'];
                }
                return [
                    'key' => $bannerField['name'],
                    'value' => $value
                ];
            });
        }) : collect();
    }

    /**
     * @return array|null
     */
    private function getModeratorData()
    {
        /** @var $item Event */
        $item = $this->resource;
        $moderator = $item->moderator;

        if (empty($moderator)) {
            return null;
        }

        return [
            'name' => $moderator->name . ' ' . $moderator->surname,
            'phone' => $moderator->phone_number,
            'email' => $moderator->email
        ];
    }

    /**
     * @return array
     */
    public function toSeoData()
    {
        /** @var $item Event */
        $item = $this->resource;
        return SeoData::setTitle($item->title . ' ' . __('seo.event.title'))
            ->setDescription($item->description . ' ' . __('seo.event.description'))
            ->setKeywords($item->description . ' ' . __('seo.event.description'))
            ->setOgTitle($item->title . ' ' . __('seo.event.title'))
            ->setOgDescription($item->description . ' ' . __('seo.event.description'))
            ->setOgImage($this->getProfileImageUrl($item))->getSeoData();
    }

    /**
     * @return array
     */
    public function toSeoDataConference()
    {
        /** @var $item Event */
        $item = $this->resource;
        return SeoData::setTitle($item->title . ' ' . __('seo.event.conference_title'))
            ->setDescription($item->description . ' ' . __('seo.event.conference_description'))
            ->setKeywords($item->description . ' ' . __('seo.event.conference_description'))
            ->setOgTitle($item->title . ' ' . __('seo.event.conference_title'))
            ->setOgDescription($item->description . ' ' . __('seo.event.conference_description'))
            ->setOgImage($this->getProfileImageUrl($item))->getSeoData();
    }
}
