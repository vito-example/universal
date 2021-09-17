<?php

namespace App\Modules\Customer\Http\Controllers\Web\Admin;

use App\Models\User;
use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Exports\ExportCustomers;
use App\Modules\Customer\Helpers\CitizenshipHelper;
use App\Modules\Customer\Helpers\CustomerHelper;
use App\Modules\Customer\Http\Requests\Admin\ActivityStoreRequest;
use App\Modules\Customer\Http\Requests\Admin\CustomerStoreRequest;
use App\Modules\Customer\Http\Resources\Activity\ActivityListResource;
use App\Modules\Customer\Http\Resources\Activity\DoctorTypeListResource;
use App\Modules\Customer\Http\Resources\Citizenship\CitizenshipListResource;
use App\Modules\Customer\Http\Resources\Customer\CustomerItemResource;
use App\Modules\Customer\Http\Resources\Customer\CustomerResource;
use App\Modules\Customer\Models\Citizenship;
use App\Modules\Customer\Models\Translations\CitizenshipTranslation;
use App\Utilities\ServiceResponse;
use Arr;
use Auth;
use Excel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Log;
use TranslationFieldsWithLocale;


class CustomerController extends BaseController
{

    protected string $baseModuleName = 'customer::';

    /**
     * @var string
     */
    public $moduleTitle = 'customer';

    /**
     * @var string
     */
    public $viewFolderName = 'customer';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'customer';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = CustomerHelper::getLang();
    }


    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();
        $this->baseData['allData'] = User::filter($filterData)->orderBy('created_at','desc')->paginate(25);
        $this->baseData['options'] = [
            'verifies'  => [
                [
                    'value' => 2,
                    'label' => __('admin.customer.is_verified')
                ],
                [
                    'value' => 1,
                    'label' => __('admin.customer.not_verified')
                ]
            ]
        ];
        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        try {
            $user = User::findOrFail($request->get('id'));
            $user->forceFill([
                'status' => $request->get('status'),
            ])->save();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200,  $this->baseData );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createData(Request $request)
    {
        try {
            $this->baseData['routes'] = CustomerHelper::getRoutes();
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') .'.image.upload');

            if ($request->get('id')) {
                $item = User::findOrFail($request->get('id'));
                $this->baseData['item']['main'] = $item->only($item->getFillable());
                $this->baseData['item']['main']['password'] = null;
            }
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex,'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200,  $this->baseData );
    }

    /**
     * @param CustomerStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            $saveData = Arr::except($request->except(['id'])['main'], ['profile']);
            if ($request->get('id')) {
                $item = User::findOrFail($request->get('id'));
                if (!empty($saveData['password'])) {
                    $saveData['password'] = bcrypt($saveData['password']);
                } else {
                    unset($saveData['password']);
                }
                $item->update($saveData);
                $item->save();
            }

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * @param string $id
     *
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = CustomerHelper::getRoutes()['create_data'];

            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $customer = User::with([
            'ownCompanies.company'
        ])->where('id',$id)->firstOrFail();
        $this->baseData['item'] = (new CustomerResource($customer))->toAdminProfile();

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.show', $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        return Excel::download(new ExportCustomers($request->all()), 'users.xlsx');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $customers = User::filter($request->all())->get();

        return response()->json([
            'data'  => [
                'items' => $customers->map(function(User $customer){
                    return (new CustomerItemResource($customer))->toArray();
                })
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsCustomer(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        Auth::guard('web')->loginUsingId($customer->id);

        return redirect()->route('profile.show');
    }

}
