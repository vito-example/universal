<?php
/**
 *  app\Modules\Event\Http\Controllers\Web\Admin\EventSessionAttemptController.php
 *
 * Date-Time: 8/16/2021
 * Time: 9:11 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Event\Helpers\EventSessionAttemptHelper;
use App\Modules\Event\Http\Requests\Admin\EventSessionRequestStoreRequest;
use App\Modules\Event\Http\Requests\Admin\EventStoreRequest;
use App\Modules\Event\Http\Resources\Event\EventItemSelectResource;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions;
use App\Modules\Event\Models\EventSession;
use App\Modules\Event\Models\EventSessionAttempt;
use App\Utilities\ServiceResponse;
use Carbon\Carbon;
use DateTimeZone;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Log;

class EventSessionAttemptController extends BaseController
{

    protected string $baseModuleName = 'event::';

    /**
     * @var string
     */
    public string $moduleTitle = 'event_session_attempt';

    /**
     * @var string
     */
    public string $viewFolderName = 'event_session_attempt';

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
        $this->baseData['baseRouteName'] .= '.event_session_attempt.';
        $this->baseData['trans_text'] = EventSessionAttemptHelper::getLang();
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();

        $this->baseData['allData'] = EventSessionAttempt::filter($filterData)->orderBy('created_at', 'desc')->event()->paginate(25);

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }


    /**
     * @param $id
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $eventSessionAttempt = EventSessionAttempt::with([

        ])->where('id', $id)->firstOrFail();
        $this->baseData['item'] = $eventSessionAttempt;
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.show', $this->baseData);
    }

    /**
     * @param EventStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(EventSessionRequestStoreRequest $request, $id)
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


            unset($saveData['user']);
            DB::connection()->beginTransaction();

            $item = EventSession::create($saveData);
            $item->attachSessionPermissions($userPermissions);

            $eventSessionAttempt = EventSessionAttempt::find($id);
            $eventSessionAttempt->delete();
            $this->baseData['redirect'] = route('admin.event_session.show', $item->id);

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
        $eventSessionAttempt = EventSessionAttempt::findOrFail($id);
        try {
            $this->baseData['event_session_attempt'] = $eventSessionAttempt->toArray();
            $this->baseData['event_session_attempt']['event_id'] = $eventSessionAttempt->session->event_id;
            $this->baseData['routes']['store'] = route('admin.event_session_attempt.store',$id);
            $this->baseData['options'] = [
                'users' => [(new CustomerItemResource($eventSessionAttempt->user))->toArray()],
                'training' => [(new EventItemSelectResource($eventSessionAttempt->session->event))->toArray()],
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $eventSessionAttempt = EventSessionAttempt::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200, $this->baseData);
    }

}
