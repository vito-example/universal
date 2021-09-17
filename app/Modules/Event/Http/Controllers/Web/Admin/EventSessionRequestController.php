<?php
/**
 *  app/Modules/Event/Http/Controllers/Web/Admin/EventSessionRequestController.php
 *
 * Date-Time: 28.07.21
 * Time: 11:25
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Event\Helpers\EventHelper;
use App\Modules\Event\Helpers\EventSessionRequestHelper;
use App\Modules\Event\Http\Requests\Admin\EventSessionRequestStoreRequest;
use App\Modules\Event\Http\Requests\Admin\EventStatusUpdateRequest;
use App\Modules\Event\Http\Requests\Admin\EventStoreRequest;
use App\Modules\Event\Http\Resources\Event\EventItemSelectResource;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventSession;
use App\Modules\Event\Models\EventSessionRequest;
use App\Utilities\ServiceResponse;
use DateTimeZone;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Log;

class EventSessionRequestController extends BaseController
{

    protected string $baseModuleName = 'event::';

    /**
     * @var string
     */
    public string $moduleTitle = 'session_request';

    /**
     * @var string
     */
    public string $viewFolderName = 'session_request';

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
        $this->baseData['baseRouteName'] .= '.session_request.';
        $this->baseData['trans_text'] = EventSessionRequestHelper::getLang();
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
//        if (auth()->user()->can(getPermissionKey('event', 'moderator', false))) {
//            $filterData['moderator_id'] = auth()->id();
//        }
        $this->baseData['allData'] = EventSessionRequest::with('user', 'event.translations')->filter($filterData)->event()->orderBy('created_at', 'desc')->paginate(25);
        $this->baseData['options'] = [
            'statuses' => (new EventSessionRequestStatusOptions())->toArray()
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
     * @param EventStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(EventSessionRequestStoreRequest $request)
    {
        try {
            $saveData = $request->except(['id']);
            $saveData['max_person'] = (int)$saveData['max_person'];
            $saveData['start_date'] = Carbon::parse($saveData['start_date']);
            $saveData['end_date'] = Carbon::parse($saveData['end_date']);
            $saveData['max_person'] = (int)$saveData['max_person'];
            $saveData['price'] = $saveData['price'] ?? null;
            $saveData['link'] = $saveData['link'] ?? null;

            $userPermissions[] = $saveData['user'];
            $sessionRequest = EventSessionRequest::where('id', (int)$saveData['session_request_id'])->firstOrFail();

            $this->baseData['redirect'] = route('admin.session_request.show', $sessionRequest->id);

            unset($saveData['user'], $saveData['session_request_id']);
            DB::connection()->beginTransaction();

            $item = EventSession::create($saveData);
            $item->attachSessionPermissions($userPermissions);

            $sessionRequest->session_id = $item->id;
            $sessionRequest->status = EventSessionRequestStatusOptions::STATUS_SUCCESS;
            $sessionRequest->save();
            $this->baseData['redirect'] = route('admin.session_request.show', $sessionRequest->id);

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
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $eventSessionRequest = EventSessionRequest::findOrFail($id);
        try {
            $this->baseData['session_request'] = $eventSessionRequest->toArray();
            $this->baseData['routes']['store'] = route('admin.session_request.store');
            $this->baseData['options'] = [
                'users' => [(new CustomerItemResource($eventSessionRequest->user))->toArray()],
                'training' => [(new EventItemSelectResource($eventSessionRequest->event))->toArray()],
                'timezone' => DateTimeZone::listIdentifiers(DateTimeZone::ALL),
                'status' => collect((new EventSessionStatusOptions())->toArray()),
                'type' => collect((new EventSessionTypeOptions())->toArray())
            ];
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
        $eventSessionRequest = EventSessionRequest::with([
            'user',
            'session',
            'event',
        ])->where('id', $id)->firstOrFail();
        $this->authorize('show', $eventSessionRequest);
        $this->baseData['item'] = $eventSessionRequest;
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
            $eventSessionRequest = EventSessionRequest::find($request->get('id'));
            $this->baseData['routes'] = EventSessionRequestHelper::getRoutes();
            $this->baseData['item'] = $eventSessionRequest;
            $this->baseData['options'] = [
                'statuses' => collect((new EventSessionRequestStatusOptions())->toArray())->map(function ($status) {
                    $status['enable'] = true;
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
    public function updateStatus(EventStatusUpdateRequest $request): JsonResponse
    {
        try {
            $sessionRequest = EventSessionRequest::findOrFail($request->get('id'));
            $sessionRequest->forceFill([
                'status' => $request->get('status')
            ])->save();
            $this->baseData['status_label'] = $sessionRequest->status_label;
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
