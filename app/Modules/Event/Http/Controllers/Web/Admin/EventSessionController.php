<?php
/**
 *  app\Modules\Event\Http\Controllers\Web\Admin\EventSessionController.php
 *
 * Date-Time: 7/25/2021
 * Time: 1:00 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Controllers\Web\Admin;

use App\Models\User;
use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Company\Http\Resources\UserEmployeeItemResource;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Event\Helpers\EventSessionHelper;
use App\Modules\Event\Http\Requests\Admin\EventSessionStatusUpdateRequest;
use App\Modules\Event\Http\Requests\Admin\EventSessionStoreRequest;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use App\Modules\Event\Http\Resources\Session\SessionItemResource;
use App\Modules\Event\Models\EventSession;
use App\Utilities\ServiceResponse;
use Carbon\Carbon;
use DateTimeZone;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Log;

class EventSessionController extends BaseController
{

    protected string $baseModuleName = 'event::';

    /**
     * @var string
     */
    public string $moduleTitle = 'event_session';

    /**
     * @var string
     */
    public string $viewFolderName = 'event_session';

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
        $this->baseData['baseRouteName'] .= '.event_session.';
        $this->baseData['trans_text'] = EventSessionHelper::getLang();
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
        $this->baseData['allData'] = EventSession::with(['event.translations'])->filter($filterData)->event()->orderBy('created_at', 'desc')->paginate(25);
        $this->baseData['options'] = [
            'statuses' => (new EventSessionStatusOptions())->toArray()
        ];
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return Application|Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = EventSessionHelper::getRoutes()['create_data'];
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
     * @return JsonResponse
     */
    public function createData(Request $request)
    {

        try {
            $this->baseData['routes'] = EventSessionHelper::getRoutes();
            $this->baseData['routes']['filters']['person_connections'] = route('admin.customer.search');
            $this->baseData['routes']['filters']['event'] = route('admin.event.search');
            $this->baseData['options']['timezones'] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            $this->baseData['options']['user_list_options'] = [];
            $this->baseData['options']['event_options'] = [];
            $this->baseData['options']['types'] = collect((new EventSessionTypeOptions())->toArray());
            $this->baseData['options']['statuses'] = collect((new EventSessionStatusOptions())->toArray());

            if ($request->get('id')) {
                $item = EventSession::where('id', $request->get('id'))->firstOrFail();
//                $this->authorize('update', $item);
                $this->baseData['item']['main'] = (new SessionItemResource($item))->toArray();
                $this->baseData['options']['user_list_options'] = $item->userPermissions->map(function (User $user) {
                    return (new CustomerItemResource($user))->toArray();
                });
            }
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param \App\Modules\Event\Http\Requests\Admin\EventSessionStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(EventSessionStoreRequest $request)
    {
        try {
            $saveData = $request->except(['id'])['main'];
            $saveData['max_person'] = (int)$saveData['max_person'];
            $saveData['start_date'] = Carbon::parse($saveData['start_date']);
            $saveData['end_date'] = Carbon::parse($saveData['end_date']);
            $saveData['max_person'] = (int)$saveData['max_person'];

            $userPermissions = $saveData['user_list'] ?? [];
            unset($saveData['user_list']);
            DB::connection()->beginTransaction();

            if ($request->get('id')) {
                $item = EventSession::findOrFail($request->get('id'));
                $item->update($saveData);

            } else {
                $item = EventSession::create($saveData);
            }
            $item->attachSessionPermissions($userPermissions);
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
        $eventSession = EventSession::findOrFail($id);
//        $this->authorize('update', $event);
        try {
            $this->baseData['routes']['create_form_data'] = EventSessionHelper::getRoutes()['create_data'];
            $this->baseData['id'] = $eventSession->id;
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
        $eventSession = EventSession::with([
            'event.translations',
            'employeeAttendees',
            'userAttendees',
        ])->where('id', $id)->firstOrFail();
        $this->authorize('show', $eventSession);
        $this->baseData['item'] = $eventSession;
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.show', $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getUpdateStatusData(Request $request)
    {
        try {
            $event = EventSession::find($request->get('id'));
            $this->baseData['routes'] = EventSessionHelper::getRoutes();
            $this->baseData['item'] = $event;
            $this->baseData['options'] = [
                'statuses' => collect((new EventSessionStatusOptions())->toArray())->map(function ($status) {
                    $permissionKey = getPermissionKey('event_session', 'status_update_' . $status['value'], false);
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
     * @param EventSessionStatusUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateStatus(EventSessionStatusUpdateRequest $request): JsonResponse
    {
        try {
            $eventSession = EventSession::findOrFail($request->get('id'));
            $eventSession->forceFill([
                'status' => $request->get('status')
            ])->save();
            $this->baseData['status_label'] = $eventSession->status_label;
        } catch (\Exception $ex) {
            Log::error('[Error update status]', [
                'error' => $ex
            ]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200, $this->baseData);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $direction = EventSession::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200, $this->baseData);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function destroyAttendees(Request $request, EventSession $session, int $id): JsonResponse
    {
        try {
            $session->attendees()->detach($id);
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
        $userEmployeeConnections = UserEmployeeConnection::whereHas('morphable', function (Builder $builder) use ($request) {
            $builder->filter([
                'q' => $request->get('q')
            ]);
        })->get();

        return response()->json([
            'data' => [
                'items' => $userEmployeeConnections->map(function (UserEmployeeConnection $userEmployeeConnection) {
                    return (new UserEmployeeItemResource($userEmployeeConnection))->toArray();
                })
            ]
        ]);
    }

    /**
     * @param \App\Modules\Event\Models\EventSession $session
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getAttends(EventSession $session)
    {
        try {
            $this->baseData['attendees'] = $session->attendees()->pluck('id');
            $this->baseData['routes']['add_attends'] = route('admin.event_session.add_attends', $session->id);
            $this->baseData['routes']['search_attends'] = route('admin.event_session.search');
            $this->baseData['options_attendees'] = $session->attendees->map(function (UserEmployeeConnection $userEmployeeConnection) {
                return (new UserEmployeeItemResource($userEmployeeConnection))->toArray();
            });
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.add_attends', ServiceResponse::error($ex->getMessage(), $this->baseData));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.add_attends', ServiceResponse::success($this->baseData));
    }

    /**
     * @param EventSession $session
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttends(EventSession $session, Request $request): JsonResponse
    {
        try {
            $personAttendees = $request->get('attendees');
            $countAttendees = count($personAttendees);

            // Increment if max person less than attendees total
            if ($countAttendees > $session->max_person) {
                $session->increment('max_person', ($countAttendees - $session->max_person));
            }

            $session->attendees()->detach();
            $session->attendees()->attach($personAttendees);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }


        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

}
