<?php

namespace App\Modules\Company\Http\Controllers\Web\Admin;

use App\Models\User;
use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Company\Helpers\CompanyActivityHelper;
use App\Modules\Company\Helpers\CompanyHelper;
use App\Modules\Company\Http\Requests\Admin\CompanyStoreRequest;
use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Http\Resources\Company\EditResource;
use App\Modules\Company\Http\Resources\CompanyActivity\CompanyActivityItemResource;
use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeEditItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Customer\Http\Resources\Customer\CustomerResource;
use App\Modules\Event\Models\Event;
use App\Utilities\ServiceResponse;
use Arr;
use CompanyStore;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

use Log;

class CompanyController extends BaseController
{

    protected string $baseModuleName = 'company::';

    /**
     * @var string
     */
    public $moduleTitle = 'company';

    /**
     * @var string
     */
    public $viewFolderName = 'company';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'company';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = CompanyHelper::getLang();
    }

    /**
     * @param Request $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();

        $this->baseData['allData'] = Company::filter($filterData)->orderBy('created_at', 'desc')->paginate(25);
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyHelper::getRoutes()['create_data'];

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
    public function createData(Request $request)
    {
        try {
            $this->baseData['routes'] = CompanyHelper::getRoutes();
            $this->baseData['routes']['filters']['users'] = route('admin.customer.search');
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') . '.image.upload');
            $this->baseData['options'] = [];
            $this->baseData['item']['employees'] = [];
            if ($request->get('id')) {
                $item = Company::findOrFail($request->get('id'));
                $this->baseData['item'] = (new EditResource($item))->toArray();
                $this->baseData['options']['users'] = $item->ownerMembers->map(function ($ownerMember) {
                    return (new CustomerItemResource($ownerMember->user))->toArray();
                });
            };
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param CompanyStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $eventResource = CompanyStore::setCompanyById($request->get('id'))
                ->setInfoData($request->get('main'))
                ->setEmployees($request->get('employees'))
                ->store()
                ->getCompanyResource();
            $this->baseData['item'] = $eventResource->toArray();

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

    /**
     * @param string $id
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyHelper::getRoutes()['create_data'];
            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $item = Company::with([
            'ownerMembers.user',
            'images'
        ])->where('id', $id)->firstOrFail();
        $this->baseData['item'] = $item;
        $this->baseData['profile_image'] = $item->getImageByKey('profile');

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.show', $this->baseData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            Company::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        try {
            Company::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $customers = Company::filter($request->all())->get();

        return response()->json([
            'data' => [
                'items' => $customers->map(function (Company $item) {
                    return (new CompanyItemResource($item))->toArray();
                })
            ]
        ]);
    }

}
