<?php

namespace App\Modules\Event\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Http\Resources\Activity\ActivityListResource;
use App\Modules\Customer\Http\Resources\Direction\DirectionListResource;
use App\Modules\Event\Helpers\EventHelper;
use App\Modules\Event\Http\Requests\Admin\EventStatusUpdateRequest;
use App\Modules\Event\Http\Requests\Admin\EventStoreRequest;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Http\Resources\Event\EventItemEditResource;
use App\Modules\Event\Http\Resources\Event\EventItemResource;
use App\Modules\Event\Http\Resources\Event\EventItemSelectResource;
use App\Modules\Event\Http\Resources\Event\EventPriceOptions;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use App\Modules\Event\Models\Event;
use App\Utilities\ServiceResponse;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Log;
use StoreEventData;

class EventController extends BaseController
{

    protected string $baseModuleName = 'event::';

    /**
     * @var string
     */
    public string $moduleTitle = 'event';

    /**
     * @var string
     */
    public string $viewFolderName = 'event';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'event';
        $this->baseData['baseRouteName'] .= '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = EventHelper::getLang();
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();
        if (!empty($filterData['statuses'])) {
            $filterData['statuses'] = explode(',', $filterData['statuses']);
        }
        if (!empty($filterData['types'])) {
            $filterData['types'] = explode(',', $filterData['types']);
        }
        if (!empty($filterData['forms'])) {
            $filterData['forms'] = explode(',', $filterData['forms']);
        }

        $this->baseData['allData'] = Event::filter($filterData)->orderBy('created_at', 'desc')->paginate(25);
        $this->baseData['options'] = [
            'statuses' => (new EventStatusOptions())->toArray(),
            'types'  => (new EventTypeOptions())->toArray(),
            'forms' => (new EventFormOptions())->toArray()
        ];

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return Application|Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = EventHelper::getRoutes()['create_data'];

        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::success($this->baseData));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createData(Request $request): JsonResponse
    {
        try {
            $this->baseData['routes'] = EventHelper::getRoutes();
            $this->baseData['routes']['filters']['lecturers'] = route('admin.lecturer.search');
            $this->baseData['routes']['filters']['person_connections'] = route('admin.customer.search');
            $this->baseData['routes']['entities']['users'] = route('admin.customer.show_profile');
            $this->baseData['routes']['entities']['companies'] = route('admin.company.show');
            $this->baseData['routes']['entities']['lecturers'] = route('admin.lecturer.show');
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') . '.image.upload');
            $this->baseData['directions'] = (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray();

            if ($request->get('id')) {
                $item = Event::with(['translations', 'images'])->where('id', $request->get('id'))->firstOrFail();
//                $this->authorize('update', $item);
                $this->baseData['item'] = (new EventItemEditResource($item));
            }
            $this->baseData['options']['banners_attributes'] = config('event.banners_attributes');
            $this->baseData['options']['sessions_attributes'] = config('event.sessions_attributes');
            $this->baseData['options']['files_attributes'] = config('event.files_attributes');
            $this->baseData['options']['currencies'] = config('event.currencies');
            $this->baseData['options']['humans_attributes'] = config('event.humans_attributes');
            $this->baseData['options']['price_options'] = (new EventPriceOptions())->toArray();
            $this->baseData['options']['activities'] = (new ActivityListResource())->getAndSetAllResources()->toArray();
            $this->baseData['options']['types'] = collect((new EventTypeOptions())->toArray());
            $this->baseData['options']['forms'] = collect((new EventFormOptions())->toArray());
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param EventStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(EventStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $event = Event::find($request->get('id'));
//            if($event) {
//                $this->authorize('update', $event);
//            }
            $eventResource = StoreEventData::setAuthUser(auth()->user())
                ->setEventById($request->get('id'))
                ->setInfoData($request->get('main'))
                ->setSeoData($request->get('seo_meta'))
                ->setBannersData($request->get('banners'))
                ->setOptionData($request->get('options'))
                ->setLecturersData($request->get('humans'))
                ->setSessionsData($request->get('event_sessions'))
                ->store()->getEventResource();
            $this->baseData['item'] = $eventResource->toArray();
            DB::commit();
        } catch (\Exception $ex) {
            Log::error('[Error store event]', [
                'error' => $ex
            ]);
            $code = $ex->getCode();
            return ServiceResponse::jsonNotification($ex->getMessage(), $code && is_numeric($code) ? (int)$code : Response::HTTP_INTERNAL_SERVER_ERROR, []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
//        $this->authorize('update', $event);
        try {
            $this->baseData['routes']['create_form_data'] = EventHelper::getRoutes()['create_data'];
            $this->baseData['id'] = $event->id;
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage(), $this->baseData));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $event = Event::with([
            'images',
            'translations',
            'directions',
            'lecturers.translations',
            'sessions',
        ])->where('id', $id)->firstOrFail();
        $this->authorize('show', $event);
        $this->baseData['item'] = (new EventItemResource($event))->toArray();
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.show', $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpdateStatusData(Request $request)
    {
        try {
            $event = Event::find($request->get('id'));
            $this->authorize('statusUpdate', $event);
            $this->baseData['routes'] = EventHelper::getRoutes();
            $this->baseData['item'] = $event;
            $this->baseData['options'] = [
                'statuses' => collect((new EventStatusOptions())->toArray())->map(function ($status) {
                    $permissionKey = getPermissionKey('event', 'status_update_' . $status['value'], false);
                    if ($permissionKey && auth()->user()->can($permissionKey)) {
                        $status['enable'] = true;
                    } else {
                        $status['enable'] = false;
                    }
                    return $status;
                })->where('enable', true)->values()
            ];
        } catch (\Exception $ex) {
            Log::error('[Error update status]', [
                'error' => $ex
            ]);
            $code = $ex->getCode();
            return ServiceResponse::jsonNotification($ex->getMessage(), $code && is_numeric($code) ? (int)$code : Response::HTTP_INTERNAL_SERVER_ERROR, []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

    /**
     * @param EventStatusUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(EventStatusUpdateRequest $request)
    {
        try {
            $event = Event::findOrFail($request->get('id'));
            $this->authorize('statusUpdate', $event);
            $event->forceFill([
                'status' => $request->get('status')
            ])->save();
            $this->baseData['status_label'] = $event->status_label;
        } catch (\Exception $ex) {
            Log::error('[Error update status]', [
                'error' => $ex
            ]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showQuestions(Request $request, $id)
    {
        $event = Event::with([
            'questions.user',
            'translations'
        ])->where('id', $id)->firstOrFail();
//        $this->authorize('showQuestions', $event);
        $this->baseData['item'] = $event;
        $this->baseData['questions'] = (new QuestionListResource($event->questions->sortByDesc('id')))->toArray();

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.questions', $this->baseData);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function attendees(Request $request, $id)
    {
        $event = Event::with([
            'translations'
        ])->findOrFail($id);
        $attendees = EventAttendee::with([
            'user'
        ])->where('event_id', $id)->paginate($request->get('total', 25));
        $this->baseData['allData'] = $attendees;
        $this->baseData['event'] = $event;

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.attendees', $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $event = Event::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $events = Event::filter($request->only('q'))->get();

        return response()->json([
            'data' => [
                'items' => $events->map(function (Event $event) {
                    return (new EventItemSelectResource($event))->toArray();
                })
            ]
        ]);
    }

}
