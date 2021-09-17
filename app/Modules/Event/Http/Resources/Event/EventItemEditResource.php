<?php


namespace App\Modules\Event\Http\Resources\Event;


use App\Models\User;
use App\Modules\Company\Http\Resources\UserEmployeeItemResource;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\Translations\EventTranslation;
use Carbon\Carbon;
use GetImageWithType;
use Illuminate\Http\Resources\Json\JsonResource;
use TranslationFieldsWithLocale;

class EventItemEditResource extends JsonResource
{

    /**
     * EventItemEditResource constructor.
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
        /** @var $event Event */
        $item = $this->resource;
        $locales = TranslationFieldsWithLocale::setTranslations($item->translations)->setTranslationFields((new EventTranslation())->getFillable())
            ->generateFieldsWithLocales()->getFieldsWithLocales();
        $images = GetImageWithType::setImages($item->images->toArray() ?: [])->generateWithType()->getImagesWithType();
        $itemData['main'] = $locales;
        $itemData['main'] = array_merge($itemData['main'], $item->only($item->getFillable()));
        $itemData['main']['images'] = $images;
        $itemData['banners'] = $item->banners_meta;
        $itemData['humans'] = [
            'lecturers' => [
                'fields' => $this->getLecturerWithConfigMeta($item)
            ],
        ];

        foreach ($locales as $key => $locale) {
            $itemData['seo_meta'][$key] = $locale['seo_meta'] ?? [
                    'title' => '',
                    'description' => '',
                    'keyword' => ''
                ];
        }

        $itemData['event_sessions'] = [
            'sessions' => [
                'fields' => $this->getSessionWithConfigMeta($item)
            ]
        ];

        $itemData['main']['directions'] = $item->directions ? $item->directions()->pluck('id')->toArray() : [];;
//        dd($itemData['main']['directions']);
        $itemData['options'] = [
            'event_meta' => $item->event_meta ?: [
                'iframe' => ''
            ],
            'form' => $item->form,
            'type' => $item->type
        ];


        return $itemData;
    }

    /**
     * @param Event $event
     *
     * @return array
     */
    public function getSessionWithConfigMeta(Event $event): array
    {
        $sessionsConfigMeta = config('event.sessions_attributes.sessions');
        $data = [];
        if ($event->sessions) {
            foreach ($event->sessions as $session) {
                $sessionsConfigMeta[0]['value'] = $session->max_person;
                $sessionsConfigMeta[1]['value'] = $session->start_date;
                $sessionsConfigMeta[2]['value'] = $session->end_date;
                $sessionsConfigMeta[3]['value'] = $session->timezone;
                $sessionsConfigMeta[3]['session_id'] = $session->id;
                $sessionsConfigMeta[4]['value'] = $session->status ?? 100;
                $sessionsConfigMeta[5]['value'] = $session->type ?? 100;
                $sessionsConfigMeta[6]['value'] = $session->price;
                $sessionsConfigMeta[7]['value'] = $session->link;
                if ($session->type === EventSessionTypeOptions::SESSION_TYPE_REQUEST && $session->userPermissions) {
                    $sessionsConfigMeta[5]['user_list'] = $session->userPermissions()->pluck('id');
                    $sessionsConfigMeta[5]['user_list_options'] = $session->userPermissions->map(function (User $user) {
                        return (new CustomerItemResource($user))->toArray();
                    });
                }

                $data[] = [
                    ...$sessionsConfigMeta
                ];
            }
        }
        return $data;
    }

    /**
     * @param Event $event
     *
     * @return array
     */
    public function getLecturerWithConfigMeta(Event $event): array
    {
        $lecturersConfigMeta = config('event.humans_attributes.lecturers');
        $data = [];
        if ($event->lecturers()) {
            foreach ($event->lecturers as $lecturer) {
                $lecturersConfigMeta[1]['options'] = [
                    [
                        'image_url' => $lecturer->getImageByKey('profile'),
                        'label' => $lecturer->full_name,
                        'value' => $lecturer->id
                    ]
                ];
                $lecturersConfigMeta[1]['value'] = $lecturer->id;

                $data[] = [
                    ...$lecturersConfigMeta
                ];
            }
        }
        return $data;
    }
}
